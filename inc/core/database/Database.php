<?php


// Handles database connection, table creation, and initialization.
class Database {
    protected $connection;

    private $create_statements = [
        "CREATE TABLE IF NOT EXISTS Bill(
            id                  INT AUTO_INCREMENT,
            number_of_items     INT(20) NOT NULL,
            total_cost          FLOAT(25, 5) NOT NULL,
            order_date          DATE,
            status              ENUM('empty', 'pending', 'cancelled', 'completed') NOT NULL,
            PRIMARY KEY         (id)
        );",
        "CREATE TABLE IF NOT EXISTS MenuItem(
            id                  INT AUTO_INCREMENT,
            name                VARCHAR(100) NOT NULL,
            price               FLOAT(25, 5) NOT NULL,
            cost_to_produce     FLOAT(25, 5) NOT NULL,
            description         TEXT,
            image               VARCHAR(100),
            discount            FLOAT(2, 2),
            tags                VARCHAR(100),
            ingredients         VARCHAR(100),
            stock_count         INT,
            items_sold          INT,
            profit_generated    FLOAT(25, 5),
            PRIMARY KEY         (id)
        );",
        "CREATE TABLE IF NOT EXISTS BillItem(
            id                  INT AUTO_INCREMENT,
            name                VARCHAR(100) NOT NULL,
            price               FLOAT(25, 5) NOT NULL,
            total               FLOAT(25, 5) NOT NULL,
            amount              INT NOT NULL,
            discount            FLOAT(2, 2),
            bill_id             INT NOT NULL,
            menu_item_id        INT NOT NULL,
            FOREIGN KEY         (bill_id) REFERENCES Bill(id) ON DELETE CASCADE,
            FOREIGN KEY         (menu_item_id) REFERENCES MenuItem(id) ON DELETE CASCADE,
            PRIMARY KEY         (id)
        );",
        "CREATE TABLE IF NOT EXISTS Employee(
            id                  INT AUTO_INCREMENT,
            first_name          VARCHAR(30) NOT NULL,
            last_name           VARCHAR(30) NOT NULL,
            other_names         VARCHAR(100),
            gender              BOOLEAN,
            age                 INT,
            dob                 DATE,
            job_role            ENUM('owner',  'manager', 'cashier', 'cook', 'server','clerk') NOT NULL,
            email               VARCHAR(50) NOT NULL,
            contact_number      VARCHAR(20) NOT NULL,
            image_url           VARCHAR(100),
            user_id             INT,
            status              ENUM('active', 'onleave','dismissed') DEFAULT 'active',
            FOREIGN KEY         (user_id) REFERENCES User(id) ON DELETE CASCADE,
            PRIMARY KEY         (id)
        );",
         "CREATE TABLE IF NOT EXISTS User(
            id                  INT AUTO_INCREMENT,
            email               VARCHAR(100) NOT NULL,
            password            VARCHAR(100) NOT NULL,
            role                ENUM('manager', 'cashier') NOT NULL,
            PRIMARY KEY         (id)
        );",//Change made here
        "CREATE TABLE IF NOT EXISTS RoomInfo(
            id                  INT AUTO_INCREMENT,
            number              INT,
            type                ENUM('Single', 'Double', 'Deluxe') DEFAULT 'Single' NOT NULL,
            details             VARCHAR(100) NOT NULL,
            price               FLOAT(25, 5) NOT NULL,
            image_url           VARCHAR(100),
            status              ENUM('Available', 'Occupied') DEFAULT 'Available',
            view                VARCHAR(50),
            crib                BOOLEAN,
            number_of_beds      INT,
            cleaning_date       DATE
            PRIMARY KEY         (id)
        );",
        "CREATE TABLE IF NOT EXISTS GuestInfo(
            id                  VARCHAR(13) NOT NULL, 
            first_name          VARCHAR(30) NOT NULL,
            last_name           VARCHAR(30) NOT NULL,
            gender              ENUM('Male', 'Female', 'Other') NOT NULL,
            age                 INT NOT NULL,
            phone_number        VARCHAR(20) NOT NULL,
            email               VARCHAR(50) NOT NULL,
            passport_no         VARCHAR(20) NOT NULL,
            license_no         VARCHAR(20) NOT NULL,
            user_id             INT,
            FOREIGN KEY         (user_id) REFERENCES User(id) ON DELETE CASCADE,
            PRIMARY KEY         (id)
        );",
        "CREATE TABLE IF NOT EXISTS Reservation(
            id                  INT AUTO_INCREMENT,
            guest_id            VARCHAR(13),
            user_id             INT,
            room_id             INT,
            check_in            BOOLEAN
            FOREIGN KEY         (guest_id) REFERENCES GuestInfo(id) ON DELETE CASCADE,
            FOREIGN KEY         (user_id) REFERENCES User(id) ON DELETE CASCADE,
            FOREIGN KEY         (room_Id) REFERENCES RoomInfo(id) ON DELETE CASCADE,
            PRIMARY KEY         (id)
        )
        "
    ];


    private $initMenuItemSQL =
     "INSERT IGNORE INTO MenuItem(id, name, price, cost_to_produce, description, image, discount, tags, ingredients, stock_count, items_sold, profit_generated)
    VALUES (:id, :name, :price, :cost_to_produce, :description, :image, :discount, :tags, :ingredients, :stock_count, :items_sold, :profit_generated)";

    private $initEmployeeDataSQL =
        "INSERT IGNORE INTO Employee(id, first_name, last_name, other_names, gender, age, dob, job_role, email, contact_number, image_url, status)
         VALUES (:id, :first_name, :last_name, :other_names, :gender, :age, :dob, :job_role, :email, :contact_number, :image_url, :status)"; 
    private $initGuestDataSQL =
    "INSERT IGNORE INTO GuestInfo(id, first_name, last_name, gender, age, phone_number, email, passport_no, license_no)
     VALUES (:id, :first_name, :last_name, :gender, :age, :phone_number, :email, :passport_no, :license_no)";

    private $initRoomDataSQL =
    "INSERT IGNORE INTO RoomInfo(id, number, type, details, price, image_url, status)
     VALUES (:id, :number, :type, :details, :price, :image_url, :status)";

    public function connect() {
        $driver = DB_DRIVER;
        $host = DB_HOST;
        $db = DB_NAME;
        $user = DB_USER;
        $password = DB_USER_PASSWORD;

        $dsn = "$driver:host=$host;dbname=$db;charset=UTF8";

        $this->connection = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public function init() {
        $this->connect();
        try {
            if ($this->connection) {
                
                foreach ($this->create_statements as $statement) {
                    $this->connection->exec($statement);
                }
                
                if(!isset($_COOKIE['init'])) {
                    setcookie("init", true, time() + (10 * 365 * 24 * 60 * 60), "/");
                    $this->menuItemInit();
                    $this->employeeDataInit();
                    $this->guestDataInit();
                    $this->roomDataInit();
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function menuItemInit() {

        $menu_data = [
            [
                'id' => 1,
                'name' => 'Chocolate Chip Ice Cream',
                'price' => 1000,
                'cost_to_produce' => 500,
                'description' => 'Creamy vanilla ice cream with swirls of chocolate chips.',
                'image' => 'chocolate-chip-ice-cream.png',
                'discount' => 0.15,
                'tags' => 'chocolate, dessert',
                'ingredients' => 'ice cream, chocolate chip, chocolate syrup',
                'stock_count' => 20,
                'items_sold' => 0,
                'profit_generated' => 0
            ],
            [
                'id' => 2,
                'name' => 'Strawberry Swirl Sundae',
                'price' => 1500,
                'cost_to_produce' => 1000,
                'description' => 'Fresh strawberries layered with vanilla ice cream and topped with whipped cream.',
                'image' => 'strawberry-swirl-sundae.png',
                'discount' => 0.20,
                'tags' => 'strawberry, dessert',
                'ingredients' => 'strawberries, ice cream',
                'stock_count' => 10,
                'items_sold' => 0,
                'profit_generated' => 0
            ]
        ];

        foreach ($menu_data as $data) {
            $statement = $this->connection->prepare($this->initMenuItemSQL);
            $statement->execute($data);
        }

    }


    private function employeeDataInit() {

        $employee_data = [
            [
                'id' => 1,
                'first_name' => "Dave",
                'last_name' => "Dunder",
                'other_names' => "John",
                'gender' => 1,
                'age' => 37,
                'dob' => '1986-05-23',
                'job_role' => 'owner',
                'email' => 'davejohn@gmail.com',
                'contact_number' => '656-5334',
                'image_url' => 'owner.jpg',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'first_name' => "Ricardo",
                'last_name' => "Narine",
                'other_names' => "Joshua",
                'gender' => 1,
                'age' => 18,
                'dob' => '2005-01-23',
                'job_role' => 'manager',
                'email' => 'ricardo@gmail.com',
                'contact_number' => '666-1234',
                'image_url' => 'employee1.jpg',
                'status' => 'active'
            ],
            [
                'id' => 3,
                'first_name' => "Monica",
                'last_name' => "Lee",
                'other_names' => "Amy",
                'gender' => 0,
                'age' => 19,
                'dob' => '2004-01-23',
                'job_role' => 'clerk',
                'email' => 'monica@gmail.com',
                'contact_number' => '666-4321',
                'image_url' => 'employee2.jpg',
                'status' => 'active'
            ]
        ];

        foreach ($employee_data as $data) {
            $statement = $this->connection->prepare($this->initEmployeeDataSQL);
            $statement->execute($data);
        }
    }

    private function guestDataInit() {

        $guest_data = [
            [
                'id' => 12345,
                'first_name' => "Jon",
                'last_name' => "Snow",
                'gender' => 'Male',
                'age' => 37,
                'phone_number' => '656-5334',
                'email' => 'davejohn@gmail.com',
                'passport_no' => '69420-1234',
                'license_no' => '69420'
            ]
        ];

        foreach ($guest_data as $data) {
            $statement = $this->connection->prepare($this->initGuestDataSQL);
            $statement->execute($data);
        }
    }


    private function roomDataInit() {


        $room_data = [
            [
                'id' => 1,
                'number' => 10,
                'type' => "Single",
                'details' => "This is a single room",
                'price' => 1000,
                'image_url' => 'room1.jpg',
                'status' => 'Available'
            ],
            [
                'id' => 2,
                'number' => 20,
                'type' => "Single",
                'details' => "This is a single room",
                'price' => 1000,
                'image_url' => 'room2.jpg',
                'status' => 'Available'
            ],
            [
                'id' => 3,
                'number' => 30,
                'type' => "Double",
                'details' => "This is a double room",
                'price' => 2000,
                'image_url' => 'room3.jpg',
                'status' => 'Available'  
            ],
            [
                'id' => 4,
                'number' => 40,
                'type' => "Double",
                'details' => "This is a double room",
                'price' => 2000,
                'image_url' => 'room4.jpg',
                'status' => 'Available'
            ],
            [
                'id' => 5,
                'number' => 50,
                'type' => "Deluxe",
                'details' => "This is a deluxe room",
                'price' => 3000,
                'image_url' => 'room5.jpg',
                'status' => 'Available'
            ]
        ];

        foreach ($room_data as $data) {
            $statement = $this->connection->prepare($this->initRoomDataSQL);
            $statement->execute($data);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
