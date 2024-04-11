<?php

class GuestInfoController extends BaseController {
    use SearchAndFilter;

    private $model;
    private $manager;
    private $validator;

    public function __construct() {
        $this->model = new GuestInfoModel();
        // $this->manager = new MenuItemManager();
        $this->validator = new GuestInfoValidator();
    }

    public function index() {
        $menu = $this->model->findAll();
        $this->view("menu/MenuTab", $data = $menu);
    }

    public function create() {
    
        list (
            $first_name,
            $last_name,
            $gender,
            $age,
            $phone_number,
            $email,
            $passport_no,
            $license_no
        ) = $this->validator->sanitize(
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['gender'],
            $_POST['age'],
            $_POST['phone_number'],
            $_POST['email'],
            $_POST['passport_no'],
            $_POST['license_no']
        );

        if (!$this->validateInputs(
            $first_name,
            $last_name,
            $age,
            $gender,
            $phone_number,
            $email,
            $passport_no,
            $license_no
        )) {
            $this->view("menu/MenuItemAdd");
            return;
        }
    // $first_name   = $_POST['first_name'] ?? '';
    // $last_name    = $_POST['last_name'] ?? '';
    // $gender       = $_POST['gender'] ?? '';
    // $age          = $_POST['age'] ?? '';
    // $phone_number = $_POST['phone_number'] ?? '';
    // $email        = $_POST['email'] ?? '';
    // $passport_no  = $_POST['passport_no'] ?? '';
    // $license_no   = $_POST['license_no'] ?? '';
        
        // if (!$this->validateInputs(
        //     $first_name, 
        //     $last_name,
        //     $age,
        //     $gender, 
        //     $phone_number, 
        //     $email, 
        //     $passport_no, 
        //     $license_no
        // )) {
            // $this->view("menu/MenuItemAdd");
            // return;
        // }

        $this->model->set_first_name($first_name);
        $this->model->set_last_name($last_name);
        $this->model->set_gender($gender);
        $this->model->set_age($age);
        $this->model->set_phone_number($phone_number);
        $this->model->set_email($email);
        $this->model->set_passport_no($passport_no);
        $this->model->set_license_no($license_no);

        $this->model->create();
        $this->anchor("menuitem");
    }

    private function validateInputs($first_name, $last_name, $age, $gender, $phone_number, $email, $passport_no, $license_no) {
        switch (false) {
            case $this->validator->isString($first_name):
                $this->error("Enter a valid name!");
                return false;
                break;
            case $this->validator->isString($last_name):
                $this->error("Enter a valid name!");
                return false;
            case $this->validator->validateAge($age):
                $this->error("Enter a valid age!");
                return false;
            case $this->validator->validateGender($gender):
                $this->error("Enter a valid gender!");
                break;
            case $this->validator->validatePhoneNumber($phone_number):
                $this->error("Phone number should be a 7 digits!");
                return false;
                break;
            case $this->validator->isEmail($email):
                $this->error("Enter a valid email!");
                return false;
                break;
            case $this->validator->isInt($passport_no):
                $this->error("Enter a valid passport number!");
                return false;
                break;
            case $this->validator->isInt($license_no):
                $this->error("Discount should be between 1 and 0! Example 0.1");
                return false;
                break;
            default:
                return true;
                break;
        }
        return true;
    }
}