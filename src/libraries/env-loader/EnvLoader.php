<?php

namespace EnvLoader;

class EnvLoader
{
    public static function load($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception("The .env file does not exist.");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Ignore comments
            if (strpos($line, '#') === 0) {
                continue;
            }

            // Parse key-value pairs
            list($key, $value) = explode('=', $line, 2) + [null, null];
            if ($key !== null) {
                $key = trim($key);
                $value = trim($value);
                // Handle values with double quotes
                if (strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) {
                    $value = substr($value, 1, -1);
                }
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }
}
