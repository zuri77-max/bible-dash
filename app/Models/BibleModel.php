<?php

namespace App\Models;

use CodeIgniter\Model;

class BibleModel extends Model
{
    protected $table            = 'bibles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'abbreviation',
        'language',
        'description',
        'file_path',
        'file_size',
        'file_hash',
        'file_type',
        'version',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name'         => 'required|string|max_length[255]',
        'abbreviation' => 'required|string|max_length[50]',
        'language'     => 'required|string|max_length[100]',
        'file_path'    => 'required|string|max_length[500]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get all active Bibles
     */
    public function getActiveBibles()
    {
        return $this->where('is_active', 1)->findAll();
    }

    /**
     * Get Bibles by language
     */
    public function getByLanguage(string $language)
    {
        return $this->where('is_active', 1)
                    ->where('language', $language)
                    ->findAll();
    }

    /**
     * Get all unique languages
     */
    public function getLanguages()
    {
        return $this->select('language')
                    ->where('is_active', 1)
                    ->groupBy('language')
                    ->orderBy('language', 'ASC')
                    ->findAll();
    }

    /**
     * Get Bibles updated after a specific date
     */
    public function getUpdatedAfter(string $datetime)
    {
        return $this->where('is_active', 1)
                    ->where('updated_at >', $datetime)
                    ->findAll();
    }

    /**
     * Get Bible with file info
     */
    public function getWithFileInfo(int $id)
    {
        $bible = $this->find($id);
        
        if (!$bible) {
            return null;
        }

        // Add file info - check in WRITEPATH (writable directory)
        $filePath = WRITEPATH . $bible['file_path'];
        
        if (file_exists($filePath)) {
            $bible['file_exists'] = true;
            $bible['actual_file_size'] = filesize($filePath);
            $bible['file_mime_type'] = mime_content_type($filePath);
            $bible['file_name'] = basename($filePath);
        } else {
            $bible['file_exists'] = false;
        }

        return $bible;
    }

    /**
     * Format bible data for API response (single bible with updated_at)
     */
    public function formatForApi($bible)
    {
        if (!$bible) {
            return null;
        }

        // Format file size as number (it may come as string from DB)
        $fileSize = (int) $bible['file_size'];

        // Format timestamp to ISO 8601
        $createdAt = $bible['created_at'];
        if ($createdAt && !str_contains($createdAt, 'T')) {
            try {
                $date = new \DateTime($createdAt);
                $createdAt = $date->format('c');
            } catch (\Exception $e) {
                $createdAt = $createdAt;
            }
        }

        // Format updated_at timestamp
        $updatedAt = $bible['updated_at'];
        if ($updatedAt && !str_contains($updatedAt, 'T')) {
            try {
                $date = new \DateTime($updatedAt);
                $updatedAt = $date->format('c');
            } catch (\Exception $e) {
                $updatedAt = $updatedAt;
            }
        }

        return [
            'id' => (int) $bible['id'],
            'name' => $bible['name'],
            'abbreviation' => $bible['abbreviation'],
            'language' => $bible['language'],
            'description' => $bible['description'] ?? '',
            'file_hash' => $bible['file_hash'] ?? '',
            'file_size' => $fileSize,
            'file_size_formatted' => $this->formatBytes($fileSize),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    /**
     * Format list of bibles for API response (includes file_type)
     */
    public function formatListForApi($bibles)
    {
        if (empty($bibles)) {
            return [];
        }

        return array_map(function($bible) {
            // Ensure file_type is set
            if (empty($bible['file_type'])) {
                $pathInfo = pathinfo($bible['file_path']);
                $bible['file_type'] = $pathInfo['extension'] ?? 'json';
            }

            // Format file size as number (it may come as string from DB)
            $fileSize = (int) $bible['file_size'];

            // Format timestamp to ISO 8601
            $createdAt = $bible['created_at'];
            if ($createdAt && !str_contains($createdAt, 'T')) {
                try {
                    $date = new \DateTime($createdAt);
                    $createdAt = $date->format('c');
                } catch (\Exception $e) {
                    $createdAt = $createdAt;
                }
            }

            return [
                'id' => (int) $bible['id'],
                'name' => $bible['name'],
                'abbreviation' => $bible['abbreviation'],
                'language' => $bible['language'],
                'description' => $bible['description'] ?? '',
                'file_type' => $bible['file_type'],
                'file_hash' => $bible['file_hash'] ?? '',
                'file_size' => $fileSize,
                'file_size_formatted' => $this->formatBytes($fileSize),
                'created_at' => $createdAt,
            ];
        }, $bibles);
    }

    /**
     * Format list of bibles for check-updates endpoint
     */
    public function formatForCheckUpdates($bibles)
    {
        if (empty($bibles)) {
            return [];
        }

        return array_map(function($bible) {
            return [
                'id' => (int) $bible['id'],
                'abbreviation' => $bible['abbreviation'],
                'file_hash' => $bible['file_hash'] ?? '',
                'needs_update' => true,
            ];
        }, $bibles);
    }

    /**
     * Format bytes to human-readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
