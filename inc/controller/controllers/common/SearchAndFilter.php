<?php

trait SearchAndFilter {
 
    public function searchById($viewPath) {
        $searchQuery = $this->validator->sanitize($_POST['search-query']);
        
        if (!$this->validator->isInt($searchQuery)) {
            $this->error("Query should be a Integer!");
            $this->index();
            return;
        }
        
        $this->model->set_id($searchQuery);
        $data = $this->model->findById();
        $this->view($viewPath, $data = [$data]);
    }

    public function searchByName($viewPath) {
        $searchQuery = $this->validator->sanitize($_POST['search-query']);
      
        if (!$this->validator->isString($searchQuery)) {
            $this->error("Query should not be empty!");
            $this->index();
            return;
        }

        //Use of wildcards for partial matching
        $searchQuery = '%' . $searchQuery . '%';
        $this->model->set_name($searchQuery);
        
        $data = $this->model->findAllByName();
        $this->view($viewPath, $data = $data);
    }

    public function searchByLastName($viewPath) {
        $searchQuery = $this->validator->sanitize($_POST['search-query']);
        if (!$this->validator->isString($searchQuery)) {
            $this->error("Query should not be empty!");
            $this->index();
            return;
        }
            
        $this->model->set_last_name($searchQuery);
        $data = $this->model->findAllByLastName();
        $this->view($viewPath, $data = $data);
    }

    public function filterByStatus($viewPath) {
        $status = $this->validator->sanitize($_POST['status']);

        if(!$this->validator->isString($status)) {
            $this->error("Query should not be empty!");
            $this->index();
            return;
        }

        $this->model->set_status($status);
        $data = $this->model->findAllByStatus();
        $this->view($viewPath, $data = $data);
    }

    public function filterByDate($viewPath) {
        $currentDate = date('Y-m-d');
        $date = $this->validator->sanitize($_POST['date']);

        if (!$this->validator->isString($date)) {
            $this->error("Query should not be empty!");
            $this->index();
            return;
        }

        switch ($date) {
            case 'last-week':
                $currentDate = date('Y-m-d', strtotime('-1 week', strtotime($currentDate)));
                break;
            case 'last-month':
                $currentDate = date('Y-m-d', strtotime('-4 weeks', strtotime($currentDate))); 
                break;
            case 'last-six-months':
                $currentDate = date('Y-m-d', strtotime('-24 weeks', strtotime($date)));
                break;
            default:
                break;
        }

        $this->model->set_order_date($date);
        $data = $this->model->findAllWhereDateGreaterThan();
        $this->view($viewPath, $data);
    }
}

