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

        // Add file info
        $filePath = FCPATH . $bible['file_path'];
        
        if (file_exists($filePath)) {
            $bible['file_exists'] = true;
            $bible['actual_file_size'] = filesize($filePath);
            $bible['file_mime_type'] = mime_content_type($filePath);
        } else {
            $bible['file_exists'] = false;
        }

        return $bible;
    }
}
