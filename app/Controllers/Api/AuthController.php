<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    protected $format = 'json';

    /**
     * Generate Access Token for Admin
     * POST /api/auth/token
     * 
     * Body: { "email": "admin@bibleapi.com", "password": "admin123" }
     */
    public function generateToken()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return $this->fail('Email and password are required', 400);
        }

        // Attempt to authenticate
        $credentials = [
            'email'    => $email,
            'password' => $password,
        ];

        $result = auth()->attempt($credentials);

        if (!$result->isOK()) {
            return $this->failUnauthorized('Invalid credentials');
        }

        // Get the authenticated user
        $user = auth()->user();

        // Check if user is admin
        if (!$user->inGroup('admin')) {
            auth()->logout();
            return $this->failForbidden('Only admin users can access the API');
        }

        // Generate access token
        $token = $user->generateAccessToken('API Token');

        return $this->respond([
            'status' => 'success',
            'message' => 'Token generated successfully',
            'data' => [
                'token' => $token->raw_token,
                'expires_at' => $token->expires,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                ],
            ],
        ]);
    }

    /**
     * Revoke current access token
     * POST /api/auth/revoke
     */
    public function revokeToken()
    {
        $user = auth('tokens')->user();

        if (!$user) {
            return $this->failUnauthorized('No active token found');
        }

        // Get the current token
        $token = auth('tokens')->getAccessToken();
        
        if ($token) {
            $user->revokeAccessToken($token);
        }

        return $this->respond([
            'status' => 'success',
            'message' => 'Token revoked successfully',
        ]);
    }

    /**
     * Get current user info
     * GET /api/auth/me
     */
    public function me()
    {
        $user = auth('tokens')->user();

        if (!$user) {
            return $this->failUnauthorized('Unauthorized');
        }

        return $this->respond([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'groups' => $user->getGroups(),
            ],
        ]);
    }
}
