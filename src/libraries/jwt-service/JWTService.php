<?php

namespace JWTService;

class JWTService
{
    private $secretKey;
    private $tokenDir;

    public function __construct($secretKey, $tokenDir = __DIR__ . '/tokens')
    {
        $this->secretKey = $secretKey;
        $this->tokenDir = $tokenDir;

        if (!is_dir($this->tokenDir)) {
            mkdir($this->tokenDir, 0777, true);
        }
    }

    public function createToken($name, $payload)
    {
        $issuedAt = time();
        $expiration = $issuedAt + 3600; // Token valid for 1 hour

        $token = [
            'iat' => $issuedAt,
            'exp' => $expiration,
            'data' => $payload
        ];

        $jwt = $this->encodeJWT($token);

        $this->storeToken($name, $jwt, $expiration);

        return $jwt;
    }

    private function storeToken($name, $token, $expiration)
    {
        $filePath = $this->getTokenFilePath($name);
        $tokenData = [
            'token' => $token,
            'expiration' => $expiration
        ];
        file_put_contents($filePath, json_encode($tokenData));
    }

    public function validateToken($token)
    {
        $filePath = $this->getTokenFilePath($token);
        if (!file_exists($filePath)) {
            return false;
        }

        $tokenData = json_decode(file_get_contents($filePath), true);
        if ($tokenData['token'] !== $token) {
            return false;
        }

        $decoded = $this->decodeJWT($token);
        if ($decoded === false || $tokenData['expiration'] < time()) {
            $this->deleteToken($token);
            return false;
        }

        return $decoded['data'];
    }

    private function getTokenFilePath($name)
    {
        return $this->tokenDir . '/' . md5($name) . '.json';
    }

    private function deleteToken($name)
    {
        $filePath = $this->getTokenFilePath($name);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    private function encodeJWT($payload)
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $headerEncoded = base64_encode(json_encode($header));
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, $this->secretKey, true);
        $signatureEncoded = base64_encode($signature);

        return $headerEncoded . '.' . $payloadEncoded . '.' . $signatureEncoded;
    }

    private function decodeJWT($jwt)
    {
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);
        $signature = base64_decode($signatureEncoded);

        $expectedSignature = hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, $this->secretKey, true);

        if ($signature !== $expectedSignature) {
            return false;
        }

        $payload = base64_decode($payloadEncoded);
        return json_decode($payload, true);
    }
}
