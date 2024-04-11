<?php

class UserController extends BaseController {

    private $manager;
    private $validator;

    public function __construct() {
       $this->manager = new UserManager();
       $this->validator = new UserValidator();
    }

    public function index() {
        $this->view("user/Login");
    }

    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        list(
            $email,
            $password,
        ) = $this->validator->sanitize(
            $_POST['email'],
            $_POST['password']
        );

        if (!$this->validateLoginInputs(
            $email,
            $password
        )) return;

        $isValidUser = $this->manager->validateUser($email, $password);
  
        if ($isValidUser) {
            // Fetch employee_id based on the user ID
            $employeeId = $this->manager->getEmployeeIdByUserId($isValidUser['id']);

            // Fetch the first and last name of the employee
            $employeeName = $this->manager->getEmployeeNameById($employeeId);

            // Fetch the image URL of the employee
            $employeeImageUrl = $this->manager->getEmployeeImageUrlById($employeeId);

            // Update the session variables
            $_SESSION['user_id'] = $employeeId;
            $_SESSION['user_role'] = $isValidUser['role'];
            $_SESSION['employee_name'] = $employeeName;
            $_SESSION['employee_image_url'] = $employeeImageUrl;

            $this->anchor("register");
        } else {
            $this->error("Password for user with email $email is incorrect. Please try again!");
            $this->view("user/Login");
        }
    }

    public function logout() {
        // Start the session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Unset all of the session variables.
        $_SESSION = array();


        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        $this->anchor('user');
    }

    public function registerPage() {
        $this->view("user/Register");
    }

    public function register() {

        list(
            $email,
            $password,
            $con_pass,
            $role,
            $employee_id
        ) = $this->validator->sanitize(
            $_POST['email'],
            $_POST['password'],
            $_POST['confirm-password'],
            $_POST['role'],
            $_POST['employee_id']
        );

        if (!$this->validateRegisterInputs(
            $email,
            $password,
            $con_pass,
            $role,
            $employee_id,
        ))return;


        if ($role == 'cashier') {
            $this->manager->createStandardUser($email, $password,$employee_id);
        } else if ($role == 'manager'){
            $this->manager->createAdminUser($email, $password, $employee_id);
        }

        $this->anchor("user");
    }

    private function validateRegisterInputs($email, $password,$con_pass, $role, $employee_id) {
        switch (false) {
            
            case $this->validator->isEmail($email):
                $this->error("Email should not be empty and of format like youremail@gmail.com!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->isString($password):
                $this->error("Password should not be empty!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->isString($con_pass):
                $this->error("Confirm password should not be empty!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->isString($role):
                $this->error("Role should not be empty!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->isInt($employee_id):
                $this->error("Employee should be a integer number! Example: 5.");
                $this->view("user/Register");
                return false;
                break;
            case $this->manager->emailExists($email):
                $this->error("User with email $email already exists!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->validatePassword($password):
                $this->error("Password must be of mininum 8 characters. Contain atleat 1 uppercase, 1 lowercase, 1 special character and 1 number!");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->verifyPassword($password,$con_pass):
                $this->error("Password and confirm password fields do not match");
                $this->view("user/Register");
                return false;
                break;
            case $this->validator->validateRole($role):
                $this->error("Role is invalid. Please select a valid role from the dropdown!");
                $this->view("user/Register");
                return false;
                break;
            case $this->manager->verifyEmployeeId($employee_id):
                $this->error("Employee with id $employee_id does not exist! Please ensure your employee id is valid!");
                $this->view("user/Register");
                return false;
                break;
            case $this->manager->employeeAccountExists($employee_id):
                $this->error("Employee with id $employee_id already has an account!");
                $this->view("user/Register");
                return false;
                break;
            case $this->manager->verifyUserPrivileges($employee_id, $role):
                $this->error("Employee with Id : $employee_id cannot be a manager!");
                $this->view("user/Register");
                return false;
                break;
            default:
                return true;
                break;
        }
    }

    private function validateLoginInputs($email, $password) {
        switch (false) {
            case $this->validator->isEmail($email):
                $this->error("Email should not be empty and of format like youremail@gmail.com!");
                $this->index();
                return false;
                break;
            case $this->validator->isString($password):
                $this->error("Password should not be empty!");
                $this->index();
                return false;
                break;
            case $this->manager->verifyUserEmail($email):
                $this->error("Unknown user with email $email. Please see register");
                $this->index();
                return false;
                break;
            default:
                return true;
                break;
        }
    }
        
}