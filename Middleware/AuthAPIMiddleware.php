<?php

namespace Middleware;

use JWTService\JWTService;
use ResponseJSON\ResponseJSON;

class AuthAPIMiddleware
{
    private $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle()
    {
        // Check if the Authorization header exists
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';

        if (empty($authHeader)) {
            ResponseJSON::send([], 401, 'Authorization header not found');
        }

        // Extract the token from the Authorization header (Bearer token)
        $token = str_replace('Bearer ', '', $authHeader);

        // Validate the token using JWTService
        $isValid = $this->jwtService->validateToken($token);

        if (!$isValid) {
            ResponseJSON::send([], 401, 'Invalid or expired token');
        }

        // If valid, the user is authenticated and can proceed
        return true;
    }
}
