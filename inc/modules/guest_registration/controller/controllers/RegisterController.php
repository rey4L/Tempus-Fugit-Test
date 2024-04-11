<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class RegisterController extends BaseController {

    private $manager;
    private $model;
    private $validator;

    public function __construct() {
        $this->manager = new RegisterManager();
        $this->model = new BillItemModel();
        $this->validator = new RegisterValidator();
    }

    public function index() {
        if (!$this->manager->retrieveLastBillId()) {
            $this->manager->createEmptyBill();
        }
        $this->findAll();
    }

    public function findAll() {
        $this->model->set_bill_id(
            $this->manager->retrieveLastBillId()
        );

        $data = [
            "billItems" => $this->model->findAllForBill(),
            "menuList" => $this->manager->getMenuItemsList()
        ];

        $this->view("register/CashRegisterTab", $data);
    }

    public function create() {
        list(
            $name, 
            $menuId) = explode(",", $_POST['name']);

        list(
            $name, 
            $menuId) = $this->validator->sanitize($name, $menuId);

        $amount = $this->validator->sanitize($_POST['amount']);
        $stockCount = $this->manager->getStockCountForMenuItem($menuId);
        
        if (!$this->validator->validateNumberOfItems($amount, $stockCount)) {
            if($stockCount <= 0) {
                $this->error("Out of stock!");
            } else {
                $this->error("The amount value must be between 1 and Remaining stock: $stockCount!");
            }
           
            $this->index();
            return;
        }
        
        $discount = $this->manager->queryDiscountForMenuItem($menuId);
        $price = $this->manager->queryPriceForMenuItem($menuId);
        $total = ($amount * $price) - ($discount * ($price * $amount));
        $billId = $this->manager->retrieveLastBillId();

        $this->manager->updateMenuItem($menuId, $amount);

        $this->model->set_name($name);
        $this->model->set_price($price);
        $this->model->set_total($total);
        $this->model->set_amount($amount);
        $this->model->set_bill_id($billId);
        $this->model->set_discount($discount);
        $this->model->set_menu_item_id($menuId);
        
        $this->model->create();
        $this->anchor("register");
    }

    public function delete($id) {
        $this->model->set_id($id);
        $billId = $this->model->findById();

        $this->manager->updateMenuItem(
            $billId['menu_item_id'], 
            $billId['amount'], 
            true
        );

        $this->model->delete();

        $this->anchor("register");
    }

    public function update($id = 0) {
        $id = $this->manager->retrieveLastBillId();
        
        $bill = [
            "id" => $id,
            "number_of_items" => $_POST['number-of-items'],
            "total_cost" => $_POST['total']
        ];

        $this->manager->submitBill($bill);
        $this->anchor("register");
    }
}
