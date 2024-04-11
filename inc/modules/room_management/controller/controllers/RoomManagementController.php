<?php

class RoomInventoryController {

    private $model;

    public function __construct()
    {
        $this->model = new RoomInfoModel();
    }

    public function findAll() {
        $rooms = $this->model->findAll();
    }

    public function queryRooms($value, $type) {
        switch ($type) {
            case 'STATUS':
                $this->model->setStatus($value);
                $this->model->findByStatus();
                break;
            case 'TYPE':
                $this->model->setType($value);
                $this->model->findByType();
                break;
            case 'AMENITIES':
                $this->model->setType($value);
                $this->model->findByAmenities();
                break;
            default:
                break;
        }
    }

    public function setCleaningDate() {
        $date = "";
        $this->model->setCleaningDate($date);
    }


}