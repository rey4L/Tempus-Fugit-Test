<?php

class BaseController implements Controller {

    // for rendering views
    public function view($viewPath, $data = []) {
        $path = implode("/", explode("=", trim($viewPath, "=")));
        include_once __DIR__."/../view/".$path."View.php";
    }

    public function index() {}

    // achors the url
    public function anchor($path) {
        $url = BASE_URL."/".$path;
        header("Location: ".$url);
    }

    public function create() {}
    public function findAll() {}
    public function findOne($id) {}
    public function delete($id) {}
    public function update($id) {}
    public function findByEmail($email) {}

    public function error($message) {
        echo "<script>alert(\"$message\")</script>";
    }
} 
