<?php

class RoomInfoModel extends BaseModel {
    private $id;
    private $number;
    private $type;
    private $details;
    private $price;
    private $image_url;
    private $status;

    public function __construct() {
        $this->connect();
    }

    public function create() {
        $sql = "INSERT INTO RoomInfo (id, number, type, details, price, image_url, status)
        VALUES (:id, :number, :type, :details, :price, :image_url, :status)";

        $new_room = [
            "id"=>$this->id,
            "number" => $this->number,
            "type" => $this->type,
            "details" => $this->details,
            "price" => $this->price,
            "image_url" => $this->image_url,
            "status" => $this->status
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

    public function findByAvailability() {
        $sql = "SELECT * FROM RoomInfo WHERE status = :status";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['status' => $this->id]);

        return $statement->fetchAll();
    }

    public function update() {
        $sql = "UPDATE RoomInfo SET number = :number, type = :type, details = :details, price = :price, image_url = :image_url, status = :status WHERE id = :id";

        $updated_room_info = [
            "id" => $this->id,
            "number" => $this->number,
            "type" => $this->type,
            "details" => $this->details,
            "price" => $this->price,
            "image_url" => $this->image_url,
            "status" => $this->status
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($updated_room_info);
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
}
