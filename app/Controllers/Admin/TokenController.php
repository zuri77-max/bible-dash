<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TokenController extends BaseController
{
    public function index()
    {
        return view('admin/token_generate');
    }

    public function generate()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        try {
            $user = auth()->user();
            
            if (!$user) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User not authenticated'
                ]);
            }

            $data = $this->request->getJSON();
            $tokenName = $data->name ?? 'API Token';

            // Generate access token
            $token = $user->generateAccessToken($tokenName);

            return $this->response->setJSON([
                'success' => true,
                'token' => $token->raw_token,
                'expires_at' => $token->expires,
                'message' => 'Token generated successfully'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Token generation error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to generate token: ' . $e->getMessage()
            ]);
        }
    }
}
