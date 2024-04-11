<?php

// Include the database 
require_once __DIR__ . "/../../../core/database/Database.php";

// Include the base model and other models
require_once __DIR__ . "/../../../core/Model.php";
require_once __DIR__ . "/../../../core/BaseModel.php";
require_once __DIR__ . "/models/BillModel.php";
require_once __DIR__ . "/models/EmployeeModel.php";
require_once __DIR__ . "/models/MenuItemModel.php";
require_once __DIR__ . "/models/BillItemModel.php";
require_once __DIR__ . "/models/UserModel.php";
require_once __DIR__ . "/models/GuestInfoModel.php";

// Include any managers needed
require_once __DIR__ . "/managers/BillManager.php";
require_once __DIR__ . "/managers/RegisterManager.php";
require_once __DIR__ . "/managers/UserManager.php";
require_once __DIR__ . "/managers/MenuItemManager.php";