<?php

class MenuItemModel extends BaseModel {
    private $id;
    private $name;
    private $price;
    private $cost_to_produce;
    private $description;
    private $image;
    private $discount;
    private $tags;
    private $ingredients;
    private $stock_count;
    private $items_sold;
    private $profit_generated;

    public function __construct() {
        $this->connect();
    }

    public function create() {
        $sql =  "INSERT INTO MenuItem(name, price, cost_to_produce, description, image, discount, tags, ingredients, stock_count, items_sold, profit_generated)
            VALUES (:name, :price, :cost_to_produce, :description, :image, :discount, :tags, :ingredients, :stock_count, :items_sold, :profit_generated)";

        $new_menu_item = [
            "name"=> $this->name,
            "price"=> $this->price,
            "cost_to_produce"=> $this->cost_to_produce,
            "description"=> $this->description,
            "image"=> $this->image,
            "discount"=> $this->discount,
            "tags"=> $this->tags,
            "ingredients"=> $this->ingredients,
            "stock_count"=> $this->stock_count,
            "items_sold"=> $this->items_sold,
            "profit_generated"=> $this->profit_generated
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($new_menu_item);

        $this->id = $this->connection->lastInsertId();
    }

    public function findAll() {
        $statement = $this->connection->query("SELECT * FROM MenuItem");
        return $statement->fetchAll(); 
    }

    public function findAllByName() {
        $sql = "SELECT * FROM MenuItem WHERE name LIKE :name";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['name' => $this->name]);

        return $statement->fetchAll();
    }

    public function findById() {
        $sql = "SELECT * FROM MenuItem WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $this->id]);

        return $statement->fetch();
    }

    public function findAllByItemsSold() {
        $statement = $this->connection->query("SELECT * FROM MenuItem WHERE items_sold > 0 ORDER BY items_sold DESC");
        return $statement->fetchAll(); 
    }

    public function findAllByMostProfitGenerated() {
        $statement = $this->connection->query("SELECT * FROM MenuItem WHERE profit_generated > 0 ORDER BY profit_generated DESC");
        return $statement->fetchAll(); 
    }

    public function update() {
        $sql = "UPDATE MenuItem SET name = :name, price = :price, cost_to_produce = :cost_to_produce, description = :description, image = :image, discount = :discount, tags = :tags, ingredients = :ingredients, stock_count = :stock_count, items_sold = :items_sold, profit_generated = :profit_generated WHERE id = :id";
    
        $updated_menu_item = [
            "id"=> $this->id,
            "name"=> $this->name,
            "price"=> $this->price,
            "cost_to_produce"=> $this->cost_to_produce,
            "description"=> $this->description,
            "image"=> $this->image,
            "discount"=> $this->discount,
            "tags"=> $this->tags,
            "ingredients"=>$this->ingredients,
            "stock_count"=> $this->stock_count,
            "items_sold"=> $this->items_sold,
            "profit_generated"=> $this->profit_generated
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($updated_menu_item);
    }

    public function delete() {
        $sql = "DELETE FROM MenuItem WHERE id = :id";

        $deleted_menu_item = [
            "id"=> $this->id
        ];

        $statement = $this->connection->prepare($sql);
        $statement->execute($deleted_menu_item);
    }



    public function get_id() {
        return $this->id;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_price() {
        return $this->price;
    }

    public function get_cost_to_produce() {
        return $this->cost_to_produce;
    }

    public function get_description() {
        return $this->description;
    }

    public function get_image() {
        return $this->image;
    }

    public function get_discount() {
        return $this->discount;
    }

    public function get_tags() {
        return $this->tags;
    }

    public function get_stock_count() {
        return $this->stock_count;
    }

    public function get_items_sold() {
        return $this->items_sold;
    }
    
    public function get_profit_generated() {
        return $this->profit_generated;
    }

    public function get_ingredients() {
        return $this->ingredients;
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_price($price) {
        $this->price = $price;
    }

    public function set_cost_to_produce($cost_to_produce) {
        $this->cost_to_produce = $cost_to_produce;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function set_image($image) {
        $this->image = $image;
    }

    public function set_discount($discount) {
        $this->discount = $discount;
    }

    public function set_tags($tags) {
        $this->tags = $tags;
    }

    public function set_ingredients($ingredients) {
        $this->ingredients = $ingredients;
    }

    public function set_stock_count($stock_count) {
        $this->stock_count = $stock_count;
    }

    public function set_items_sold($items_sold) {
        $this->items_sold = $items_sold;
    }

    public function set_profit_generated($profit_generated) {
        $this->profit_generated = $profit_generated;
    }
}
