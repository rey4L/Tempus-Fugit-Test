<?php

class UserModel extends BaseModel {
        private $id;
        private $email;
        private $password;
        private $role;
        private $employee_id;
    
        public function __construct() {
            $this->connect();
        }
    
        public function create() {
            $sql = "INSERT INTO User(email, password, role, employee_id)
                    VALUES (:email, :password, :role, :employee_id)";
    
            $new_user = [
                "email" => $this->email,
                "password" => $this->password,
                "role" => $this->role,
                "employee_id" => $this->employee_id,
            ];
    
            $statement = $this->connection->prepare($sql);
            $statement->execute($new_user);
    
            $this->id = $this->connection->lastInsertId();
        }
    
        public function findAll() {
            $statement = $this->connection->query("SELECT * FROM User");
            return $statement->fetchAll();
        }
    
        public function findById() {
            $sql = "SELECT * FROM User WHERE id = :id";
    
            $statement = $this->connection->prepare($sql);
            $statement->execute(['id' => $this->id]);
    
            return $statement->fetch();
        }

        public function findByEmployeeId() {
            $sql = "SELECT * FROM User WHERE employee_id = :employee_id";
    
            $statement = $this->connection->prepare($sql);
            $statement->execute(['employee_id' => $this->employee_id]);
    
            return $statement->fetch();
        }

        public function findByEmail() {

            $sql = "SELECT * FROM User WHERE email = :email";

            $statement = $this->connection->prepare($sql);
            $statement->execute(['email' => $this->email]);

            return $statement->fetch();
        }
    
        public function update() {
            $sql = "UPDATE User SET password = :password, role = :role, 
                    employee_id = :employee_id WHERE id = :id";
    
            $updated_user = [
                "id" => $this->id,
                "email" => $this->email,
                "password" => $this->password,
                "role" => $this->role,
                "employee_id" => $this->employee_id,
            ];
    
            $statement = $this->connection->prepare($sql);
            $statement->execute($updated_user);
        }
    
        public function delete() {
            $sql = "DELETE FROM User WHERE id = :id";
    
            $deleted_user = [
                "id" => $this->id
            ];
    
            $statement = $this->connection->prepare($sql);
            $statement->execute($deleted_user);
        }

        public function findByRole() {
            $sql = "SELECT * FROM User WHERE role = :role LIMIT 1";
    
            $statement = $this->connection->prepare($sql);
            $statement->execute(['role' => $this->role]);
    
            return $statement->fetch();
        }
    
        public function findAllByRole() {
            $sql = "SELECT * FROM User WHERE role = :role";
    
            $statement = $this->connection->prepare($sql);
            $statement->execute(['role' => $this->role]);
    
            return $statement->fetchAll();
        }
    
        public function updateRole() {
            $sql = "UPDATE User SET role = :role WHERE id = :id";
    
            $change_user_state = [
                "id" => $this->id,
                "role" => $this->role
            ];
    
            $statement = $this->connection->prepare($sql);
            $statement->execute($change_user_state);
        }

        public function get_id() {
            return $this->id;
        }
    
        public function get_email() {
            return $this->email;
        }
    
        public function get_password() {
            return $this->password;
        }
    
        public function get_role() {
            return $this->role;
        }
    
        public function get_employee_id() {
            return $this->employee_id;
        }
    
        public function set_id($id) {
            $this->id = $id;
        }
    
        public function set_email($email) {
            $this->email = $email;
        }
    
        public function set_password($password) {
            $this->password = $password;
        }
    
        public function set_role($role) {
            $this->role = $role;
        }
    
        public function set_employee_id($employee_id) {
            $this->employee_id = $employee_id;
        }
}