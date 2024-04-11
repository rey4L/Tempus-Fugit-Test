<?php

/**
 * Manages operations related to the cash register, including querying menu item details,
 * creating an empty bill, and handling bill submissions.
 */
class RegisterManager {
    private $menuItemModel;
    private $billModel;
    private $billItemModel;

    public function __construct() {
        $this->menuItemModel = new MenuItemModel();
        $this->billModel = new BillModel();
        $this->billItemModel = new BillItemModel();
    }

    public function queryDiscountForMenuItem($id) {
        $this->menuItemModel->set_id($id);
        $menuItem = $this->menuItemModel->findById();
        return $menuItem['discount'];
    }

    public function queryPriceForMenuItem($id) {
        $this->menuItemModel->set_id($id);
        $menuItem = $this->menuItemModel->findById();
        return $menuItem['price'];
    }

    public function getMenuItemsList() {
        $menuItem = $this->menuItemModel->findAll();
        return $menuItem;
    }

    public function updateMenuItem($id, $amount, $reset = false) {
        $this->menuItemModel->set_id($id);

        $menuItem = $this->menuItemModel->findById();
        $profitGenerated = ($amount * $menuItem['price']) - ($amount * $menuItem['price'] * $menuItem['discount']) - ($amount * $menuItem['cost_to_produce']);

        $this->menuItemModel->set_name($menuItem['name']);
        $this->menuItemModel->set_price($menuItem['price']);
        $this->menuItemModel->set_cost_to_produce($menuItem['cost_to_produce']);
        $this->menuItemModel->set_description($menuItem['description']);
        $this->menuItemModel->set_image($menuItem['image']);
        $this->menuItemModel->set_discount($menuItem['discount']);
        $this->menuItemModel->set_tags($menuItem['tags']);
        $this->menuItemModel->set_ingredients($menuItem['ingredients']);

        if (!$reset) {
            $this->menuItemModel->set_stock_count(
                $menuItem['stock_count'] - $amount
            );
            $this->menuItemModel->set_items_sold(
                $menuItem['items_sold'] + $amount
            );
            $this->menuItemModel->set_profit_generated(
                $menuItem['profit_generated'] + $profitGenerated
            );
        } else {
            $this->menuItemModel->set_stock_count(
                $menuItem['stock_count'] + $amount
            );
            $this->menuItemModel->set_items_sold(
                $menuItem['items_sold'] - $amount
            );
            $this->menuItemModel->set_profit_generated(
                $menuItem['profit_generated'] - $profitGenerated
            );
        }

        $this->menuItemModel->update();
    }

    public function createEmptyBill() {
        $this->billModel->set_customer("");
        $this->billModel->set_number_of_items(0);
        $this->billModel->set_total_cost(0);
        $this->billModel->set_order_date(NULL);
        $this->billModel->set_status("empty");
        $this->billModel->create();
    }

    public function retrieveLastBillId() {
        $this->billModel->set_status("empty");
        return $this->billModel->findByStatus()['id'] ?? false;
    }

    public function submitBill($bill) {
        $this->billModel->set_id($bill['id']);
        $this->billModel->set_number_of_items($bill['number_of_items']);
        $this->billModel->set_total_cost($bill['total_cost']);
        date_default_timezone_set('America/Guyana');
        $this->billModel->set_order_date(date("Y/m/d"));
        $this->billModel->set_status("Pending");
        $this->billModel->update();
    }

    public function getItemsForBill($id) {
        $this->billItemModel->set_bill_id($id);
        return $this->billItemModel->findAllForBill();
    }

    public function getStockCountForMenuItem($id) {
        $this->menuItemModel->set_id($id);
        return $this->menuItemModel->findById()['stock_count'];
    }

}
