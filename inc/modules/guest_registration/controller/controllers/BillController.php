<?php

class BillController extends BaseController {
    use SearchAndFilter;

    private $model;
    private $manager;
    private $validator;

    public function __construct() {
        $this->model = new BillModel();
        $this->manager = new BillManager();
        $this->validator = new Validator();
    }

    public function index() {
        $this->findAll();
    }

    public function findAll() {
        $bills = $this->model->findAllNonEmptyBills();
        $this->view("bill/BillsTab", $data = $bills);
    }

    public function findOne($id) {
        $this->model->set_id($id);
        $bill = $this->model->findById();
        $billItems = $this->manager->getItemsForBill($bill['id']);
        
        $billData = [
            "bill" => $bill,
            "billItems" => $billItems
        ];

        $this->view("bill/BillPreview", $data = $billData);
    }

    public function delete($id) {
        $this->manager->changeBillState($id, "cancelled");
        $this->anchor("bill");
    }

    public function update($id) {
        $this->manager->changeBillState($id, "completed");
        $this->anchor("bill");
    }


}
