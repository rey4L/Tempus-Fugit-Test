<?php

// Include the initialization file
require __DIR__."/init.php";

class App extends Database {

    public function __construct() {
        $this->init(); // Initialize the Database connection
        new Router(); // Create a new instance of the Router class to handle routing.
    }
}
