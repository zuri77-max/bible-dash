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
}
