<?php

namespace Redirect;

class Redirect
{
    /**
     * Redirect to a specific URL
     *
     * @param string $url The URL to redirect to
     * @param int $statusCode The HTTP status code for the redirect (default: 302 for temporary redirect)
     */
    public static function to($url, $statusCode = 302)
    {
        // Ensure no output has been sent to the browser
        if (!headers_sent()) {
            http_response_code($statusCode);
            header("Location: $url");
            exit(); // Stop script execution after redirection
        } else {
            echo "<script>window.location.href='$url';</script>";
            exit();
        }
    }

    /**
     * Redirect to the previous page (referrer)
     */
    public static function back()
    {
        $referrer = $_SERVER['HTTP_REFERER'] ?? '/'; // Default to root if no referrer
        self::to($referrer);
    }

    /**
     * Permanent redirect (301 status code)
     *
     * @param string $url The URL to redirect to
     */
    public static function permanent($url)
    {
        self::to($url, 301);
    }
}
