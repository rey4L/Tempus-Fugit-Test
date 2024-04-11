<?php

class RoomInventoryController {

    private $model;

    public function __construct()
    {
        $this->model = new RoomInfoModel();
    }

    public function allocateRooms() {
        $this->model->setStatus("Available");
        $availableRooms = $this->model->findByAvailability();

        return $availableRooms[0];
    }

    
    public function setCleaningDate() {

    }


}