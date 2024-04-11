<?php

class RoomInfoModel extends BaseModel {
    private $id;
    private $number;
    private $type;
    private $details;
    private $price;
    private $image_url;
    private $status;
    private $amenities;
    private $cleaning_date;
    private $number_of_beds;
    private $view;

    public function __construct() {
        $this->connect();
    }

    public function create() {
        $sql = "INSERT INTO RoomInfo (id, number, type, details, price, image_url, status, amenities, cleaning_date)
        VALUES (:id, :number, :type, :details, :price, :image_url, :status, amenities, cleaning_date)";

        $new_room = [
            "id"=>$this->id,
            "number" => $this->number,
            "type" => $this->type,
            "details" => $this->details,
            "price" => $this->price,
            "image_url" => $this->image_url,
            "status" => $this->status,
            "amenities" => $this->amenities,
            "cleaning_date" => $this->cleaning_date
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($new_room);

        $this->id = $this->connection->lastInsertId();
    }

    public function findAll() {
        $statement = $this->connection->query("SELECT * FROM RoomInfo");
        return $statement->fetchAll();
    }

    public function findById() {
        $sql = "SELECT * FROM RoomInfo WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $this->id]);

        return $statement->fetch();
    }

    public function findByPreferences() {
        $sql = "SELECT * FROM RoomInfo WHERE status = :status AND type = :type AND number_of_beds = :number_of_beds AND view = :view";

        $search_queries = [
            "status" => $this->status,
            "type" => $this->type,
            "number_of_beds" => $this->number_of_beds,
            "view" => $this->view
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($search_queries);

        return $statement->fetchAll();
    }

    public function findByStatus() {
        $sql = "SELECT * FROM RoomInfo WHERE status = :status";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['status' => $this->status]);

        return $statement->fetchAll();
    }

    public function findByType() {
        $sql = "SELECT * FROM RoomInfo WHERE type = :type";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['type' => $this->type]);

        return $statement->fetchAll();
    }

    public function findByAmenities() {
        $sql = "SELECT * FROM RoomInfo WHERE amenities = :amenities";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['amenities' => $this->id]);

        return $statement->fetchAll();
    }

    public function findByNumberOfBeds() {
        $sql = "SELECT * FROM RoomInfo WHERE number_of_beds = :number_of_beds";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['number_of_beds' => $this->number_of_beds]);

        return $statement->fetchAll();
    }

    public function findByView() {
        $sql = "SELECT * FROM RoomInfo WHERE view = :view";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['view' => $this->view]);

        return $statement->fetchAll();
    }


    public function update() {
        $sql = "UPDATE RoomInfo SET number = :number, type = :type, details = :details, price = :price, image_url = :image_url, status = :status, amenities = :amenities, cleaning_date = :cleaning_date WHERE id = :id";

        $updated_room_info = [
            "id" => $this->id,
            "number" => $this->number,
            "type" => $this->type,
            "details" => $this->details,
            "price" => $this->price,
            "image_url" => $this->image_url,
            "status" => $this->status,
            "amenities" => $this->amenities,
            "cleaning_date" => $this->cleaning_date
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($updated_room_info);
    }

    public function updateCleaningDate() {
        $sql = "UPDATE RoomInfo SET cleaning_date = :cleaning_date WHERE id = :id";

        $update_cleaning_date = [
            "id" => $this->id,
            "cleaning_date" => $this->cleaning_date
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($update_cleaning_date);
    }

    public function delete() {
        $sql = "DELETE FROM RoomInfo WHERE id = :id";

        $deleted_room = [
            "id" => $this->id
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($deleted_room);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setDetails($details) {
        $this->details = $details;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getImageUrl() {
        return $this->image_url;
    }

    public function setImageUrl($image_url) {
        $this->image_url = $image_url;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setAmenities($amenities) {
        $this->amenities = $amenities;
    }

    public function get_amenities() {
        return $this->amenities;
    }

    public function setCleaningDate($cleaning_date) {
        $this->cleaning_date = $cleaning_date;
    }

    public function getCleaningDate() {
        return $this->cleaning_date;
    }

    public function setNumberOfBeds($number_of_beds) {
        $this->number_of_beds = $number_of_beds;
    }

    public function getNumberOfBeds() {
        return $this->number_of_beds;
    }

    public function setView($view) {
        $this->view = $view;
    }

    public function getView($view) {
        return $this->view;
    } 
}
