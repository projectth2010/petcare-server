<?php

namespace ResponseJSON;

class ResponseJSON
{
    // Define common HTTP status codes
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_NO_CONTENT = 204;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_INTERNAL_ERROR = 500;

    /**
     * Send a JSON response with a standardized format.
     *
     * @param mixed $data Response data (can be array, object, etc.)
     * @param int $statusCode HTTP status code (default: 200 OK)
     * @param string $message Optional message to include in the response
     */
    public static function send($data, $statusCode = self::STATUS_OK, $message = '')
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        $response = [
            'status' => $statusCode,
            'message' => $message,
            'data' => $data
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }
}
