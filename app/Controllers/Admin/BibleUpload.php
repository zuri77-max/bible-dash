<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BibleModel;

class BibleUpload extends BaseController
{
    public function index()
    {
        return view('admin/upload');
    }

    public function upload()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'bible_name' => 'required|min_length[3]|max_length[255]',
            'language' => 'required|min_length[2]|max_length[50]',
            'abbreviation' => 'required|min_length[2]|max_length[10]',
            'bible_file' => [
                'rules' => 'uploaded[bible_file]|max_size[bible_file,51200]|ext_in[bible_file,json]',
                'errors' => [
                    'uploaded' => 'Please select a file to upload',
                    'max_size' => 'File size must not exceed 50MB',
                    'ext_in' => 'Only JSON files are allowed'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        $file = $this->request->getFile('bible_file');
        
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file upload');
        }

        // Read and validate JSON content
        $jsonContent = file_get_contents($file->getTempName());
        $bibleData = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->with('error', 'Invalid JSON file: ' . json_last_error_msg());
        }

        // Generate unique filename
        $newName = $file->getRandomName();
        
        // Move file to uploads directory
        if (!$file->move(WRITEPATH . 'uploads/bibles', $newName)) {
            return redirect()->back()->with('error', 'Failed to upload file');
        }

        // Save to database
        $bibleModel = new BibleModel();
        $data = [
            'name' => $this->request->getPost('bible_name'),
            'language' => $this->request->getPost('language'),
            'abbreviation' => strtoupper($this->request->getPost('abbreviation')),
            'file_path' => 'uploads/bibles/' . $newName,
            'file_size' => $file->getSize(),
            'version' => '1.0',
            'is_active' => 1
        ];

        if ($bibleModel->insert($data)) {
            return redirect()->to('admin/bibles')->with('success', 'Bible uploaded successfully!');
        } else {
            // Delete uploaded file if database insert fails
            @unlink(WRITEPATH . 'uploads/bibles/' . $newName);
            return redirect()->back()->with('error', 'Failed to save Bible to database');
        }
    }
}
