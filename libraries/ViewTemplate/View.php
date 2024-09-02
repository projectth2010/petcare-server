<?php

namespace ViewTemplate;

class View
{
    private $viewPath;

    public function __construct()
    {

        // Set default path for views
        $this->viewPath = './views/';
    }

    /**
     * Render the view
     * @param string $viewName The name of the view file (without extension)
     * @param array $data Data to be passed to the view
     */
    public function render($viewName, $data = [])
    {

        // Extract data into variables
        extract($data);

        // Construct the full view path
        $viewFile = $this->viewPath . $viewName . '.php';

        // Check if view file exists
        if (file_exists($viewFile)) {
            // Include the view file
            ob_start(); // Start output buffering
            require $viewFile;
            $content = ob_get_clean(); // Get the buffered content
            echo $content; // Output the content
        } else {
            echo "View file not found: $viewFile";
        }
    }

    /**
     * Set a custom path for views
     * @param string $path
     */
    public function setViewPath($path)
    {
        $this->viewPath = rtrim($path, '/') . '/';
    }
}
