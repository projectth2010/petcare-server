<?php

namespace Controllers;

use DatabaseDriver\DatabaseDriver;
use JWTService\JWTService;
use ResponseJSON\ResponseJSON;

class UserController
{
    private $db;
    private $jwtService;

    public function __construct(DatabaseDriver $db, JWTService $jwtService)
    {
        $this->db = $db;
        $this->jwtService = $jwtService;
    }

    public function updateAccount()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $username = $data['username'] ?? '';
        $newPassword = $data['new_password'] ?? '';

        if (!$this->jwtService->validateToken($username, $token)) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $query = "UPDATE users SET password = ? WHERE username = ?";
        $this->db->execute($query, [$hashedPassword, $username]);

        ResponseJSON::send([], 200, 'Account updated successfully');
    }

    public function updateInfo()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $userId = $data['user_id'] ?? '';
        $info = $data['info'] ?? '';

        if (!$this->jwtService->validateToken($userId, $token)) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        $query = "UPDATE user_info SET info = ? WHERE user_id = ?";
        $this->db->execute($query, [$info, $userId]);

        ResponseJSON::send([], 200, 'User info updated successfully');
    }

    public function getUser()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $payload = $this->jwtService->validateToken('user123', $token); // Token validation should be improved

        if (!$payload) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        $userId = $payload['user_id'];
        $query = "SELECT * FROM users WHERE id = ?";
        $user = $this->db->query($query, [$userId]);

        ResponseJSON::send($user, 200, 'User data retrieved successfully');
    }

    public function getInfo()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $payload = $this->jwtService->validateToken('user123', $token); // Token validation should be improved

        if (!$payload) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        $userId = $payload['user_id'];
        $query = "SELECT * FROM user_info WHERE user_id = ?";
        $info = $this->db->query($query, [$userId]);

        ResponseJSON::send($info, 200, 'User info retrieved successfully');
    }

    public function updateImage()
    {
        if (!isset($_FILES['image'])) {
            ResponseJSON::send([], 400, 'No image uploaded');
        }

        $image = $_FILES['image'];
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $payload = $this->jwtService->validateToken('user123', $token); // Token validation should be improved

        if (!$payload) {
            ResponseJSON::send([], 401, 'Unauthorized');
        }

        $userId = $payload['user_id'];

        $targetDir = __DIR__ . '/../uploads/';
        $targetFile = $targetDir . basename($image['name']);

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $query = "UPDATE user_info SET profile_image = ? WHERE user_id = ?";
            $this->db->execute($query, [$targetFile, $userId]);
            ResponseJSON::send([], 200, 'Profile image updated successfully');
        } else {
            ResponseJSON::send([], 500, 'Failed to upload image');
        }
    }
}
