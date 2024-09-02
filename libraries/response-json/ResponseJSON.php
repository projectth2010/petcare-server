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

    /**
     * Send a successful JSON response with data.
     *
     * @param array $data - Data to send in the response
     * @param string $message - Optional success message
     * @param int $statusCode - HTTP status code (default is 200)
     * @return void
     */
    public static function success($data = [], $message = 'Request successful', $statusCode = 200)
    {
        // Set HTTP response header for JSON
        http_response_code($statusCode);
        header('Content-Type: application/json');

        // Prepare the response structure
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];

        // Send the JSON response
        echo json_encode($response);
        exit;
    }

    /**
     * Send an error JSON response.
     *
     * @param string $message - Error message
     * @param int $statusCode - HTTP status code (default is 400)
     * @return void
     */
    public static function error($message = 'An error occurred', $statusCode = 400)
    {
        // Set HTTP response header for JSON
        http_response_code($statusCode);
        header('Content-Type: application/json');

        // Prepare the response structure
        $response = [
            'status' => 'error',
            'message' => $message
        ];

        // Send the JSON response
        echo json_encode($response);
        exit;
    }

    /**
     * Send a custom JSON response.
     *
     * @param array $response - Custom response structure
     * @param int $statusCode - HTTP status code
     * @return void
     */
    public static function custom($response = [], $statusCode = 200)
    {
        // Set HTTP response header for JSON
        http_response_code($statusCode);
        header('Content-Type: application/json');

        // Send the custom JSON response
        echo json_encode($response);
        exit;
    }
}
