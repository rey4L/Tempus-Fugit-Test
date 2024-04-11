<?php

class GuestInfoModel extends BaseModel {
    private $id;
    private $first_name;
    private $last_name;
    private $gender;
    private $age;
    private $phone_number;
    private $email;
    private $passport_no;
    private $license_no;

    public function __construct() {
        $this->connect();
    }

    public function create() {
        $sql =  "INSERT INTO GuestInfo(first_name, last_name, gender, age, phone_number, email, passport_no, license_no)
            VALUES (:first_name, :last_name, :gender, :age, :phone_number, :email, :passport_no, :license_no)";

        $new_guest = [
            "first_name"=> $this->first_name,
            "last_name"=> $this->last_name,
            "gender"=> $this->gender,
            "age"=> $this->age,
            "phone_number"=> $this->phone_number,
            "email"=> $this->email,
            "passport_no"=> $this->passport_no,
            "license_no"=> $this->license_no
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($new_guest);

        $this->id = $this->connection->lastInsertId();
    }

    public function findAll() {
        $statement = $this->connection->query("SELECT * FROM GuestInfo");
        return $statement->fetchAll(); 
    }

    public function findAllByFirstName() {
        $sql = "SELECT * FROM GuestInfo WHERE first_name LIKE :first_name";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['first_name' => $this->first_name]);

        return $statement->fetchAll();
    }

    public function findAllByLastName() {
        $sql = "SELECT * FROM GuestInfo WHERE last_name LIKE :last_name";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['last_name' => $this->last_name]);

        return $statement->fetchAll();
    }

    public function findById() {
        $sql = "SELECT * FROM GuestInfo WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $this->id]);

        return $statement->fetch();
    }

    public function update() {
        $sql = "UPDATE GuestInfo SET first_name = :first_name, last_name = :last_name, gender = :gender, age = :age, phone_number = :phone_number, email = :email, passport_no = :passport_no, license_no = :license_no WHERE id = :id";
    
        $updated_guest_info = [
            "id"=> $this->id,
            "first_name"=> $this->first_name,
            "last_name"=> $this->last_name,
            "gender"=> $this->gender,
            "age"=> $this->age,
            "phone_number"=> $this->phone_number,
            "email"=> $this->email,
            "passport_no"=> $this->passport_no,
            "license_no"=> $this->license_no
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($updated_guest_info);
    }

    public function delete() {
        $sql = "DELETE FROM GuestInfo WHERE id = :id";

        $deleted_guest = [
            "id"=> $this->id
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($deleted_guest);
    }



    public function get_id() {
        return $this->id;
    }

    public function get_first_name() {
        return $this->first_name;
    }

    public function get_last_name() {
        return $this->last_name;
    }

    public function get_gender() {
        return $this->gender;
    }

    public function get_age() {
        return $this->age;
    }

    public function get_phone_number() {
        return $this->phone_number;
    }

    public function get_email() {
        return $this->email;
    }

    public function get_passport_no() {
        return $this->passport_no;
    }

    public function get_license_no() {
        return $this->license_no;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function set_first_name($first_name) {
        $this->first_name = $first_name;
    }

    public function set_last_name($last_name) {
        $this->last_name = $last_name;
    }

    public function set_gender($gender) {
        $this->gender= $gender;
    }

    public function set_age($age) {
        $this->age = $age;
    }

    public function set_phone_number($phone_number) {
        $this->phone_number = $phone_number;
    }

    public function set_email($email) {
        $this->email = $email;
    }

    public function set_passport_no($passport_no) {
        $this->passport_no = $passport_no;
    }

    public function set_license_no($license_no) {
        $this->license_no = $license_no;
    }
}