<?php
class Controller {
    private $load;
    private $model;

    public function __construct($action = 'home') {
        $this->load  = new Load();
        $this->model = new Model();

        // Call the requested action (method) if it exists:
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 – action not found";
        }
    }

    // Renders your main homepage
    public function home() {
        $data = []; // pull any data you need here
        $this->load->view('home', $data);
    }

    // Returns JSON array of brands
    public function listBrands() {
        header('Content-Type: application/json');
        echo json_encode($this->model->getBrands());
    }

    // Returns JSON details for a single brand via ?brand=…
    public function drinkDetails() {
        header('Content-Type: application/json');
        $brand = $_GET['brand'] ?? '';
        echo json_encode($this->model->getDrinkDetails($brand));
    }

    /**
 * Create the drinks table.
 */
public function apiCreateTable() {
    $message = $this->model->dbCreateTable();
    $this->load->view('viewMessage', ['message' => $message]);
}

/**
 * Seed the drinks table.
 */
public function apiInsertData() {
    $message = $this->model->dbInsertData();
    $this->load->view('viewMessage', ['message' => $message]);
}

/**
 * Fetch all drinks records.
 */
public function apiGetData() {
    $records = $this->model->dbGetData();
    $this->load->view('view3DAppData', ['records' => $records]);
}

}
