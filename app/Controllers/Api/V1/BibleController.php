<?php

namespace App\Controllers\Api\V1;

use App\Models\BibleModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class BibleController extends ResourceController
{
    protected $modelName = 'App\Models\BibleModel';
    protected $format    = 'json';

    /**
     * List all Bibles (with optional language filter)
     * GET /api/v1/bibles
     * GET /api/v1/bibles?language=English
     */
    public function index()
    {
        $language = $this->request->getGet('language');

        if ($language) {
            $bibles = $this->model->getByLanguage($language);
        } else {
            $bibles = $this->model->getActiveBibles();
        }

        $formattedBibles = $this->model->formatListForApi($bibles);

        return $this->respond([
            'success' => true,
            'data' => $formattedBibles,
        ]);
    }

    /**
     * Get available languages
     * GET /api/v1/bibles/languages
     */
    public function languages()
    {
        $languages = $this->model->getLanguages();
        
        // Extract just the language names
        $languageList = array_map(function($item) {
            return $item['language'];
        }, $languages);

        return $this->respond([
            'success' => true,
            'data' => $languageList,
        ]);
    }

    /**
     * Get single Bible
     * GET /api/v1/bibles/{id}
     */
    public function show($id = null)
    {
        $bible = $this->model->find($id);

        if (!$bible) {
            return $this->failNotFound('Bible version not found');
        }

        $formattedBible = $this->model->formatForApi($bible);

        return $this->respond([
            'success' => true,
            'data' => $formattedBible,
        ]);
    }

    /**
     * Check for Bible updates
     * GET /api/v1/bibles/check-updates?last_sync=2025-01-01T00:00:00Z
     */
    public function checkUpdates()
    {
        $lastSync = $this->request->getGet('last_sync');

        if (!$lastSync) {
            return $this->failValidationErrors('last_sync parameter is required');
        }

        try {
            $updatedBibles = $this->model->getUpdatedAfter($lastSync);
            $formattedBibles = $this->model->formatForCheckUpdates($updatedBibles);

            return $this->respond([
                'success' => true,
                'data' => $formattedBibles,
                'has_updates' => count($formattedBibles) > 0,
            ]);
        } catch (\Exception $e) {
            return $this->failValidationErrors('Invalid date format for last_sync');
        }
    }

    /**
     * Get Bible file info
     * GET /api/v1/bibles/{id}/file-info
     */
    public function fileInfo($id = null)
    {
        $bible = $this->model->getWithFileInfo($id);

        if (!$bible) {
            return $this->failNotFound('Bible version not found');
        }

        if (!$bible['file_exists']) {
            return $this->fail('Bible file not found on server', 404);
        }

        // Determine file type
        if (empty($bible['file_type'])) {
            $pathInfo = pathinfo($bible['file_path']);
            $bible['file_type'] = $pathInfo['extension'] ?? 'json';
        }

        return $this->respond([
            'success' => true,
            'data' => [
                'id' => (int) $bible['id'],
                'abbreviation' => $bible['abbreviation'],
                'file_name' => $bible['file_name'],
                'file_size' => (int) $bible['actual_file_size'],
                'file_hash' => $bible['file_hash'] ?? '',
                'file_type' => $bible['file_type'],
                'mime_type' => $bible['file_mime_type'],
                'supports_resume' => true,
            ],
        ]);
    }

    /**
     * Download Bible file
     * GET /api/v1/bibles/{id}/download
     */
    public function download($id = null)
    {
        $bible = $this->model->find($id);

        if (!$bible) {
            return $this->failNotFound('Bible version not found');
        }

        $filePath = WRITEPATH . $bible['file_path'];

        if (!file_exists($filePath)) {
            return $this->fail('Bible file not found on server', 404);
        }

        // Determine mime type based on file type
        $mimeType = 'application/json';
        if (!empty($bible['file_type'])) {
            if ($bible['file_type'] === 'db') {
                $mimeType = 'application/octet-stream';
            }
        }

        // Set headers for download
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'inline; filename="' . basename($filePath) . '"')
            ->setHeader('Content-Length', filesize($filePath))
            ->setHeader('Accept-Ranges', 'bytes')
            ->setHeader('Cache-Control', 'must-revalidate')
            ->setHeader('Pragma', 'public')
            ->setBody(file_get_contents($filePath));
    }
}
