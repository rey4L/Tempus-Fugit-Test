<?php

class GuestInfoController extends BaseController {
    use SearchAndFilter;

    private $model;
    private $manager;
    private $validator;

    public function __construct() {
        $this->model = new GuestInfoModel();
        // $this->manager = new MenuItemManager();
        // $this->validator = new GuestInfoValidator();
    }

    public function index() {
        $menu = $this->model->findAll();
        $this->view("menu/MenuTab", $data = $menu);
    }

    public function create() {
        
        list(
            $first_name, 
            $last_name,
            $age,
            $gender, 
            $phone_number, 
            $email, 
            $passport_no, 
            $license_no

        ) = $this->validator->sanitize(
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['age'],
            $_POST['gender'],
            $_POST['phone_number'],
            $_POST['email'],
            $_POST['passport_no'],
            $_POST['license_no']
        );

        // if (!$this->validateInputs(
        //     $first_name, 
        //     $last_name,
        //     $age,
        //     $gender, 
        //     $phone_number, 
        //     $email, 
        //     $passport_no, 
        //     $license_no
        // )) {
            $this->view("menu/MenuItemAdd");
            return;
        // }

        $this->model->get_first_name($first_name);
        $this->model->get_last_name($last_name);
        $this->model->get_age($age);
        $this->model->get_gender($gender);
        $this->model->get_phone_number($phone_number);
        $this->model->get_phone_number($email);
        $this->model->get_passport_no($passport_no);
        $this->model->get_license_no($license_no);

        $this->model->create();
        $this->anchor("menuitem");
    }


    public function delete($id) {
        $this->model->set_id($id);
        $this->model->delete();
        $this->anchor("menuitem");
    }


    public function update($id) {

        list(
            $name,
            $price,
            $cost_to_produce,
            $description,
            $image,
            $discount,
            $tags,
            $ingredients,
            $stock_count

        ) = $this->validator->sanitize(
            $_POST['name'],
            $_POST['price'],
            $_POST['cost-to-produce'],
            $_POST['description'],
            $_POST['image'],
            $_POST['discount'],
            $_POST['tags'],
            $_POST['ingredients'],
            $_POST['stock']
        );

        if (!$this->validateInputs(
            $name,
            $price,
            $cost_to_produce,
            $description,
            $image,
            $discount,
            $tags,
            $ingredients,
            $stock_count
        )) {
            $this->index();
            return;
        }
        // $this->model->set_id($id);
        // $this->model->set_name($name);
        // $this->model->set_price($price);
        // $this->model->set_cost_to_produce($cost_to_produce);
        // $this->model->set_description($description);
        // $this->model->set_image($image);
        // $this->model->set_discount($discount);
        // $this->model->set_tags($tags);
        // $this->model->set_ingredients($ingredients);
        // $this->model->set_stock_count($stock_count);
        // $this->model->set_items_sold(0);
        // $this->model->set_profit_generated(0);

        $this->model->update();
        $this->anchor("menuitem");
    }

    public function showMostSoldItems() {
         
        $items = $this->manager->getMostSoldItems();
        $labels = "";
        $values = "";

        foreach($items as $item) {
            if(!empty($labels)) {
                $labels = $labels.",".$item['name'];
                $values = $values.",".$item['items_sold'];
            } else {
                $labels = $item['name'];
                $values = $item['items_sold'];
            }
        }

        $data = [
            "labels" => $labels,
            "data" => $values,
        ];

        $this->view("menu/MostSoldItemsChart", $data);
    }

    public function showMostProfitableItems() {
        
        $items = $this->manager->getMostProfitableItems();
        $labels = "";
        $values = "";

        foreach($items as $item) {
            if(!empty($labels)) {
                $labels = $labels.",".$item['name'];
                $values = $values.",".$item['profit_generated'];
            } else {
                $labels = $item['name'];
                $values = $item['profit_generated'];
            }
        }

        $data = [
            "labels" => $labels,
            "data" => $values,
        ];

        $this->view("menu/MostProfitableItemsChart", $data);
    }

    public function showMostSoldWithinPeriod() {

        list(
            $startDate,
            $endDate
        ) = $this->validator->sanitize(
            $_POST['start-date'],
            $_POST['end-date']
        );

        if (!$this->validateGraphInputs(
            $startDate,
            $endDate
        )) return;

        $items = $this->manager->getItemsSoldWithinPeriod(
            $startDate,
            $endDate
        );

        $labels = "";
        $values = "";

        foreach ($items['labels'] as $label) {
            if(!empty($labels)) {
                $labels = $labels.",".$label;
            } else {
                $labels = $label;
            }
        }

        foreach ($items['data'] as $data) {
            if(!empty($values)) {
                $values = $values.",".$data;
            } else {
                $values = $data;
            }
        }

        $data = [
            "start"=>$startDate,
            "end"=>$endDate,
            "labels" => $labels,
            "data" => $values,
        ];

        $this->view("menu/PeriodItemsChart", $data);
    }

    public function showMostSoldWithinPeriodLine() {
        list(
            $startDate,
            $endDate
        ) = $this->validator->sanitize(
            $_POST['start-date'],
            $_POST['end-date']
        );

        if (!$this->validateGraphInputs(
            $startDate,
            $endDate
        )) return;

        $items = $this->manager->getItemsSoldWithinPeriodLine(
            $startDate,
            $endDate
        );

        $labels = "";
        $values = "";

        foreach($items['title'] as $item) {
            if(!empty($labels)) {
                $labels = $labels.",".$item;
            } else {
                $labels = $item;
            }
        }

        foreach($items['data'] as $data) {
            if(!empty($values)) {
                $values = $values.",".implode("-", $data);
            } else {
                $values = implode("-", $data);
            }
        }

        $data = [
            "labels" => $labels,
            "data" => $values,
            "start"=>$startDate,
            "end"=>$endDate,
        ];

        $this->view("menu/PeriodItemsChartLine", $data);
    }

    private function validateGraphInputs($startDate, $endDate) {
        switch (false) {
            case $this->validator->validateDate($startDate):
                $this->error("Start date should be of valid format: yyyy-mm-dd");
                $this->index();
                return false;
                break;
            case $this->validator->validateDate($endDate):
                $this->error("End date should be of valid format: yyyy-mm-dd");
                $this->index();
                return false;
                break;
            default:
                return true;
                break;
        }
    }

    private function validateInputs($name, $price, $cost_to_produce, $description, $image, $discount, $tags, $ingredients, $stock_count) {
        switch (false) {
            case $this->validator->isString($name):
                $this->error("Name should not be empty!");
                return false;
                break;
            case $this->validator->isInt($price):
                $this->error("Price should be a number!. Example: 1, 24.5");
                return false;
                break;
            case $this->validator->isFloat($cost_to_produce):
                $this->error("Cost to produce should be a valid floating number! Example 0.1, 4");
                return false;
                break;
            case $this->validator->isString($description):
                $this->error("Description should not be empty!");
                return false;
                break;
            case $this->validator->isString($image):
                $this->error("Image should not be empty!");
                return false;
                break;
            case $this->validator->isFloat($discount):
                $this->error("Discount should be a valid floating number! Example 0.1, 4");
                return false;
                break;
            case $this->validator->validateDiscount($discount):
                $this->error("Discount should be between 1 and 0! Example 0.1");
                return false;
                break;
            case $this->validator->validateTags($tags):
                $this->error("Tags should be in valid format and should not be empty! Example tag1,tag2");
                return false;
                break;
            case $this->validator->validateTags($ingredients):
                $this->error("Ingredients should be in valid format and should not be empty! Example ingredient1,ingredient2");
                return false;
                break;
            case $this->validator->isInt($stock_count):
                $this->error("Stock count should be a number!");
                return false;
                break;
            default:
                return true;
                break;
        }
        return true;
    }


  
}
