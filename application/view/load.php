
<?php
/**
 * Load class
 * Responsible for loading view files and injecting data into them.
 */
class Load {

      /**
     * Loads a PHP view file and extracts variables from the provided data array.
     *
     * @param string $file_name Name of the PHP file (without .php extension) to include.
     * @param array $data Associative array of data to be extracted as variables in the view.
     */
    public function view($file_name, $data = []) {
        // If $data is an array, extract it to variables
        if (is_array($data)) {
            extract($data);
        }
        // Include the requested view file
        require __DIR__ . "/{$file_name}.php";
    }
}
