<?php

// Include the database 
require __DIR__ . "/../../../core/database/Database.php";

// Include the base model and other models
require __DIR__ . "/../../../core/Model.php";
require __DIR__ . "/../../../core/BaseModel.php";
require __DIR__ . "/models/BillModel.php";
require __DIR__ . "/models/EmployeeModel.php";
require __DIR__ . "/models/MenuItemModel.php";
require __DIR__ . "/models/BillItemModel.php";
require __DIR__ . "/models/UserModel.php";
require __DIR__ . "/models/GuestInfoModel.php";

// Include any managers needed
require __DIR__ . "/managers/BillManager.php";
require __DIR__ . "/managers/RegisterManager.php";
require __DIR__ . "/managers/UserManager.php";
require __DIR__ . "/managers/MenuItemManager.php";