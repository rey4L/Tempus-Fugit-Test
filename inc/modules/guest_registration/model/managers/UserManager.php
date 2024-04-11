<?php

class UserManager {

    private $userModel;
    private $employeeModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->employeeModel = new EmployeeModel();
    }
    
    public function createStandardUser($email, $password, $employee_id) {
        $this->userModel->set_email($email);
        $this->userModel->set_password($password);        
        $this->userModel->set_role("cashier");
        $this->userModel->set_employee_id($employee_id);

        $this->userModel->set_password(
            password_hash($password, PASSWORD_DEFAULT)
        );

        $this->userModel->create();
    }

    public function createAdminUser($email, $password, $employee_id) {
        $this->userModel->set_email($email);
        $this->userModel->set_password($password);
        $this->userModel->set_role("manager");
        $this->userModel->set_employee_id($employee_id);

        $this->userModel->set_password(
            password_hash($password, PASSWORD_DEFAULT)
        );

        $this->userModel->create();
    }

    public function validateUser($email, $password){
        $this->userModel->set_email($email);
        $user = $this->userModel->findByEmail();
        
        if (isset($user) && password_verify($password, $user['password'])) {
            return $user;
        } 
        
        return false;
    }

    public function verifyUserPrivileges($id, $role) {
        $this->employeeModel->set_id($id);
        $employee = $this->employeeModel->findById();

        $valid_manager_jobs = ['owner', 'manager', 'cook'];

        if (!in_array($employee['job_role'], $valid_manager_jobs) && $role === 'manager') 
            return false;

        return true;
    }

    public function verifyUserEmail($email) {
        $this->userModel->set_email($email);
        return $this->userModel->findByEmail();
    }

    public function emailExists ($email) {
        $this->userModel->set_email($email);
        return !$this->userModel->findByEmail() ? true : false;
    }

    public function verifyEmployeeId($id) {
        $this->employeeModel->set_id($id);
        return $this->employeeModel->findById();
    }

    public function employeeAccountExists($id) {
        $this->userModel->set_employee_id($id);
        return !$this->userModel->findByEmployeeId() ? true : false;
    }

    public function getEmployeeIdByUserId($userId) {
        $this->userModel->set_id($userId);
        $user = $this->userModel->findById();

        if ($user) {
            return $user['employee_id'];
        }

        return null;
    }

    public function getEmployeeNameById($employeeId) {
        $this->employeeModel->set_id($employeeId);
        $employee = $this->employeeModel->findById();

        if ($employee) {
            $firstName = $employee['first_name'];
            $lastName = $employee['last_name'];
            return "$firstName $lastName";
        }

        return null;
    }

    public function getEmployeeImageUrlById($employeeId) {
        $this->employeeModel->set_id($employeeId);
        $employee = $this->employeeModel->findById();

        if ($employee) {
            return $employee['image_url'];
        }

        return null;
    }
}