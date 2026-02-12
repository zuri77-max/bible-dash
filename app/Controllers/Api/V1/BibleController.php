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

        return $this->respond([
            'status' => 'success',
            'data' => $bibles,
            'count' => count($bibles),
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
            'status' => 'success',
            'data' => $languageList,
            'count' => count($languageList),
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

        return $this->respond([
            'status' => 'success',
            'data' => $bible,
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

            return $this->respond([
                'status' => 'success',
                'data' => $updatedBibles,
                'count' => count($updatedBibles),
                'has_updates' => count($updatedBibles) > 0,
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

        return $this->respond([
            'status' => 'success',
            'data' => [
                'id' => $bible['id'],
                'name' => $bible['name'],
                'abbreviation' => $bible['abbreviation'],
                'language' => $bible['language'],
                'version' => $bible['version'],
                'file_size' => $bible['actual_file_size'],
                'file_mime_type' => $bible['file_mime_type'],
                'download_url' => base_url("api/v1/bibles/{$id}/download"),
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

        $filePath = FCPATH . $bible['file_path'];

        if (!file_exists($filePath)) {
            return $this->fail('Bible file not found on server', 404);
        }

        // Set headers for download
        return $this->response
            ->setHeader('Content-Type', 'application/octet-stream')
            ->setHeader('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"')
            ->setHeader('Content-Length', filesize($filePath))
            ->setHeader('Accept-Ranges', 'bytes')
            ->setHeader('Cache-Control', 'must-revalidate')
            ->setHeader('Pragma', 'public')
            ->setBody(file_get_contents($filePath));
    }
}
