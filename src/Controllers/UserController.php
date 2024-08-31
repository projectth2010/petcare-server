<?php

namespace Controllers;

use DatabaseDriver\DatabaseDriver;
use DatabaseDriver\SQL\MySQLDriver;
use JWTService\JWTService;
use ResponseJSON\ResponseJSON;

class UserController
{
    private $db;
    private $jwtService;

    public function __construct(MySQLDriver $db, JWTService $jwtService)
    {
        $this->db = $db;
        $this->jwtService = $jwtService;
    }
    public function index()
    {
        ResponseJSON::send([], 200, 'Welcome Api 1.0');
    }
    public function updateAccount()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $username = $data['username'] ?? '';
        $newPassword = $data['new_password'] ?? '';

        // Validate token
        $payload = $this->jwtService->validateToken($token);

        if (!$payload || $payload['username'] !== $username) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update password
        $result = $this->db->update('users', ['password' => $hashedPassword], ['username' => $username]);

        if ($result) {
            ResponseJSON::send([], 200, 'Account updated successfully');
        } else {
            ResponseJSON::send([], 500, 'Failed to update account');
        }
    }

    public function updateInfo()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $userId = $data['user_id'] ?? '';
        $info = $data['info'] ?? '';

        // Validate token
        $payload = $this->jwtService->validateToken($token);

        if (!$payload || $payload['user_id'] !== $userId) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        // Update user info
        $result = $this->db->update('user_info', ['info' => $info], ['user_id' => $userId]);

        if ($result) {
            ResponseJSON::send([], 200, 'User info updated successfully');
        } else {
            ResponseJSON::send([], 500, 'Failed to update user info');
        }
    }

    public function getUser()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $payload = $this->jwtService->validateToken($token);

        if (!$payload) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        $userId = $payload['user_id'];
        $user = $this->db->read('users', ['id' => $userId]);

        if ($user) {
            ResponseJSON::send($user[0], 200, 'User data retrieved successfully');
        } else {
            ResponseJSON::send([], 404, 'User not found');
        }
    }

    public function getInfo()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $payload = $this->jwtService->validateToken($token);

        if (!$payload) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        $userId = $payload['user_id'];
        $info = $this->db->read('user_info', ['user_id' => $userId]);

        if ($info) {
            ResponseJSON::send($info[0], 200, 'User info retrieved successfully');
        } else {
            ResponseJSON::send([], 404, 'User info not found');
        }
    }

    public function updateImage()
    {
        if (!isset($_FILES['image'])) {
            ResponseJSON::send([], 400, 'No image uploaded');
        }

        $image = $_FILES['image'];
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $payload = $this->jwtService->validateToken($token);

        if (!$payload) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        $userId = $payload['user_id'];
        $targetDir = __DIR__ . '/../uploads/';
        $targetFile = $targetDir . basename($image['name']);

        // Ensure the uploads directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Update profile image path in database
            $result = $this->db->update('user_info', ['profile_image' => $targetFile], ['user_id' => $userId]);

            if ($result) {
                ResponseJSON::send([], 200, 'Profile image updated successfully');
            } else {
                ResponseJSON::send([], 500, 'Failed to update profile image');
            }
        } else {
            ResponseJSON::send([], 500, 'Failed to upload image');
        }
    }
}
