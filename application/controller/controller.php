<?php
class Controller
{
    private $load;
    private $model;

    public function __construct($autoHome = 'home')
    {
        $this->load = new Load();
        $this->model = new Model();
        if ($autoHome) {
            $this->$autoHome(); // Only call home if not suppressed
        }
    }

    // Renders your main homepage
    public function home()
    {
        $data = []; // pull any data you need here
        $this->load->view('home', $data);
    }

    // Returns JSON array of brands
    public function listBrands()
    {
        header('Content-Type: application/json');
        echo json_encode($this->model->getBrands());
    }

    // Returns JSON details for a single brand via ?brand=…
    public function drinkDetails()
    {
        header('Content-Type: application/json');
        $brand = $_GET['brand'] ?? '';
        echo json_encode($this->model->getDrinkDetails($brand));
    }

    /**
     * Create the drinks table.
     */
    public function apiCreateTable()
    {
        $msg = $this->model->dbCreateTable();
        header('Content-Type: text/plain');
        echo $msg;
    }


    /**
     * Seed the drinks table.
     */
    public function apiInsertData()
    {
        $message = $this->model->dbInsertData();
        $this->load->view('viewMessage', ['message' => $message]);
    }

    /**
     * Fetch all drinks records.
     */
    public function apiGetData()
    {
        $records = $this->model->dbGetData();
        $this->load->view('view3DAppData', ['records' => $records]);
    }

    public function apiGetDrink()
    {
        $brand = $_GET['brand'] ?? '';
        $data = $this->model->dbGetDrinkDetails($brand);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function apiGetBrands()
    {
        $data = $this->model->dbGetBrandList();
        header('Content-Type: application/json');
        echo json_encode($data);
    }



}
