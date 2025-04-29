<?php
class Load {
    public function view($file_name, $data = []) {
        // If $data is an array, extract it to variables
        if (is_array($data)) {
            extract($data);
        }
        // Include the requested view file
        require __DIR__ . "/{$file_name}.php";
    }
}
