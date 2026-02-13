<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BibleModel;

class BibleManageController extends BaseController
{
    protected $bibleModel;

    public function __construct()
    {
        $this->bibleModel = new BibleModel();
    }

    public function index()
    {
        $data['bibles'] = $this->bibleModel->orderBy('created_at', 'DESC')->findAll();
        
        return view('admin/bibles/index', $data);
    }

    public function delete($id)
    {
        $bible = $this->bibleModel->find($id);
        
        if (!$bible) {
            return redirect()->back()->with('error', 'Bible not found');
        }

        if ($this->bibleModel->delete($id)) {
            return redirect()->to('admin/bibles')->with('success', 'Bible deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete Bible');
    }

    public function toggleStatus($id)
    {
        $bible = $this->bibleModel->find($id);
        
        if (!$bible) {
            return $this->response->setJSON(['success' => false, 'message' => 'Bible not found']);
        }

        $newStatus = $bible['is_active'] ? 0 : 1;
        
        if ($this->bibleModel->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Status updated successfully',
                'is_active' => $newStatus
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    public function update($id)
    {
        $bible = $this->bibleModel->find($id);
        
        if (!$bible) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Bible not found']);
            }
            return redirect()->back()->with('error', 'Bible not found');
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'abbreviation' => 'required|min_length[2]|max_length[10]',
            'language' => 'required|min_length[2]|max_length[100]',
            'description' => 'max_length[1000]',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $validation->getErrors()]);
            }
            return redirect()->back()->withInput()->with('error', 'Validation failed');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'abbreviation' => strtoupper($this->request->getPost('abbreviation')),
            'language' => $this->request->getPost('language'),
            'description' => $this->request->getPost('description'),
        ];

        if ($this->bibleModel->update($id, $data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true, 'message' => 'Bible updated successfully']);
            }
            return redirect()->to('admin/bibles')->with('success', 'Bible updated successfully');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update Bible']);
        }
        return redirect()->back()->with('error', 'Failed to update Bible');
    }}