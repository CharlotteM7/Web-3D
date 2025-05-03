<?php
/**
* Main Controller Class
* Handles routing and interaction with the Model and Views for the Web 3D App.
* Each method corresponds to an endpoint or view.
*/
class Controller
{
    private $load;
    private $model;

    /**
     * Constructor
     * Automatically loads the homepage unless otherwise suppressed.
     */

    public function __construct($autoHome = 'home')
    {
        $this->load = new Load();
        $this->model = new Model();
        if ($autoHome) {
            $this->$autoHome(); // Calls home() if $autoHome is set
        }
    }

    /**
     * Default homepage view renderer
     */
    public function home()
    {
        $data = []; // Extend this to fetch and pass data to the view if needed
        $this->load->view('home', $data);
    }

    /**
     * Returns a JSON array of all drink brands
     */
    public function listBrands()
    {
        header('Content-Type: application/json');
        echo json_encode($this->model->getBrands());
    }

    /**
     * Returns JSON details for a single brand (via ?brand=...)
     */
    public function drinkDetails()
    {
        header('Content-Type: application/json');
        $brand = $_GET['brand'] ?? '';
        echo json_encode($this->model->dbgetDrinkDetails($brand));
    }

    /**
     * API: Create the drinks table in the database
     */
    public function apiCreateTable()
    {
        $msg = $this->model->dbCreateTable();
        header('Content-Type: text/plain');
        echo $msg;
    }


    /**
     * API: Insert predefined data into the drinks table
     */
    public function apiInsertData()
    {
        $msg = $this->model->dbInsertData();
        header('Content-Type: text/plain');
        echo $msg;
    }

    /**
     * API: Get all drink data from the database
     */
    public function apiGetData()
    {
        $records = $this->model->dbGetData();
        header('Content-Type: application/json');
        echo json_encode($records);
    }

    public function apiGetDrink()
    {
        $brand = $_GET['brand'] ?? '';
        $data = $this->model->dbGetDrinkDetails($brand);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    /**
     * API: Get detailed info for one drink by brand
     */
    public function apiGetBrands()
    {
        $data = $this->model->dbGetBrandList();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * API: Get gallery image filenames associated with a drink
     */
    public function apiGetGallery()
    {
        header('Content-Type: application/json');

        $drink = $_GET['drink'] ?? '';
        $images = $this->model->dbGetGalleryImages($drink);

        echo json_encode($images);
    }

}
