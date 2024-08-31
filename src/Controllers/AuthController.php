<?php

namespace Controllers;

use DatabaseDriver\Core\DatabaseDriver;
use DatabaseDriver\SQL\MySQLDriver;
use JWTService\JWTService;
use ResponseJSON\ResponseJSON;

class AuthController
{
    private $db;
    private $jwtService;

    public function __construct(MySQLDriver $db, JWTService $jwtService)
    {
        $this->db = $db;
        $this->jwtService = $jwtService;
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($username) || empty($password)) {
            ResponseJSON::send([], 400, 'Username and password are required');
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Save user to database using the create method
        $result = $this->db->create('users', [
            'username' => $username,
            'password' => $hashedPassword
        ]);

        if ($result) {
            ResponseJSON::send([], 201, 'User registered successfully');
        } else {
            ResponseJSON::send([], 500, 'Failed to register user');
        }
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($username) || empty($password)) {
            ResponseJSON::send([], 400, 'Username and password are required');
        }

        // Retrieve user from database using the read method
        $filters = ['username' => $username];
        $user = $this->db->read('users', $filters);

        if (empty($user)) {
            ResponseJSON::send([], 401, 'Invalid credentials');
        }

        $user = $user[0]; // Assuming the username is unique and will return a single user

        if (!password_verify($password, $user['password'])) {
            ResponseJSON::send([], 401, 'Invalid credentials');
        }

        // Create token
        $payload = ['user_id' => $user['id']];
        $token = $this->jwtService->createToken($username, $payload);

        ResponseJSON::send(['token' => $token], 200, 'Login successful');
    }

    public function logout()
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';

        if (empty($authHeader)) {
            ResponseJSON::send([], 400, 'Authorization token is required');
        }

        $token = str_replace('Bearer ', '', $authHeader);

        // Optional: Blacklist token by storing it in the database or memory
        $blacklistResult = $this->db->create('token_blacklist', [
            'token' => $token
        ]);

        if ($blacklistResult) {
            ResponseJSON::send([], 200, 'Logout successful');
        } else {
            ResponseJSON::send([], 500, 'Failed to log out');
        }
    }
}
