<?php

class EmployeeController extends BaseController {
    use SearchAndFilter;

    private $model;
    private $validator;

    public function __construct() {
        $this->model = new EmployeeModel();
        $this->validator = new EmployeeValidator();
    }

    public function index() {
       $this->findAll();
    }

    public function findAll() {
        $employees = $this->model->findAll();
        $this->view("employee/EmployeesTab", $data = $employees);
    }

    public function create() { 

        list(
            $firstName,
            $lastName,
            $otherNames,
            $gender,
            $age,
            $dob,
            $jobRole,
            $email,
            $contactNumber
        ) = $this->validator->sanitize(
            $_POST['first-name'],
            $_POST['last-name'],
            $_POST['other-names'],
            $_POST['gender'],
            $_POST['age'],
            $_POST['dob'],
            $_POST['job-role'],
            $_POST['email'],
            $_POST['contact-number']
        );
        
        if (!$this->validateInputs(
            $firstName,
            $lastName,
            $otherNames,
            $gender,
            $age,
            $dob,
            $jobRole,
            $email,
            $contactNumber
        )) return;

        $this->model->set_first_name($firstName);
        $this->model->set_last_name($lastName);
        $this->model->set_other_names($otherNames);
        $this->model->set_gender($gender);
        $this->model->set_age($age);
        $this->model->set_dob($dob);
        $this->model->set_job_role($jobRole);
        $this->model->set_email($email);
        $this->model->set_contact_number($contactNumber);
        $this->model->set_status("active");

        $this->model->create();
    }

    public function findOne($id) {
        $this->model->set_id($id);
        $data = $this->model->findById();
        $this->view("employee/Employee", $data);
    }

    private function validateInputs($firstName, $lastName, $otherNames, $gender, $age, $dob, $jobRole, $email, $contactNumber) {
        switch (false) {
            case $this->validator->isString($firstName):
                $this->error("First name is not of type string");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this->validator->isString($lastName):
                $this->error("Last name is not of type string");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this ->validator->validateTags($otherNames):
                $this->error("Other names is not valid. Please input in correct string format!");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this->validator->validateGender($gender):
                $this->error("Gender must be either Male or Female");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this->validator->validateAge($age):
                $this->error("Employee must be between (inclusive of) 18 and 70");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this->validator->validateDate($dob):
                $this->error("Date of Birth is not it valid format: yyyy-mm-dd");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this->validator->validateDobAndAge($dob, $age):
                $this->error("Inputted Age: $age does not match DOB: $dob");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this->validator->validateJobRole($jobRole):
                $this->error("Job role of type $jobRole does not exist!");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this->validator->isEmail($email):
                $this->error("Email is not valid!");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            case $this->validator->validatePhoneNumber($contactNumber):
                $this->error("Contact number is not valid! A seven digit guyanese number is required.");
                $this->view("employee/EmployeeAdd");
                return false;
                break;
            default:
                return true;
                break;
        }

        return true;
    }
}
