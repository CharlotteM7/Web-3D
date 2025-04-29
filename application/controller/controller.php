<?php
class Controller {
    public $load;
    public $model;

    public function __construct() {
        // Instantiate the loader and model
        $this->load  = new Load();
        $this->model = new Model();

        // Kick off the default action
        $this->home();
    }

    public function home() {
        // Fetch any data your model provides (for now, no real data needed)
        $data = []; 
        // Render the view file: application/view/home.php
        $this->load->view('home', $data);
    }
}
