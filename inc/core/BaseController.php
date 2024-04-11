<?php

class BaseController implements Controller {

    // for rendering views
    public function view($viewPath, $data = []) {
        $modules = ["guest_registration", "check_in_check_out", "integration_and_accessibility", "reporting_and_analytics", "room_management", "user_management_and_permissions"];

        foreach ($modules as $module) {
                
            $path = implode("/", explode("=", trim($viewPath, "=")));
            $file_name =  __DIR__."/../modules/$module/view/".$path."View.php";

            if (file_exists($file_name)) {
                include_once $file_name;
                return;
            }
        }
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
