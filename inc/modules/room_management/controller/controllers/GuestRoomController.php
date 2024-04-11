<?php

class RoomManagementController {

    private $model;

    public function __construct()
    {
        $this->model = new RoomInfoModel();
    }

    public function allocateRoom() {
        $type = "";
        $view = "";
        $number_of_beds = 0;
        $availability = "";

        $this->model->setType($type);
        $this->model->setStatus($availability);
        $this->model->setNumberOfBeds($number_of_beds);
        $this->model->setView($view);

        $result = $this->model->findByPreferences();

        if (count($result) == 0) {
            echo "No room was found matching those preferences. Please try again";
            return;
        } 
    }

    public function requestRoomUpgrade() {
    
    }

    public function requestAmenities() {

    }
    
}