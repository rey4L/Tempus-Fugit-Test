<?php

// Include the common interface and base controller
require_once __DIR__."/../../../core/Controller.php";
require_once __DIR__."/../../../core/BaseController.php";

// Include traits
require_once __DIR__."/controllers/common/SearchAndFilter.php";

// Include specific controllers
require_once __DIR__."/controllers/ErrorController.php";
require_once __DIR__."/controllers/UserController.php";
require_once __DIR__."/controllers/MenuItemController.php";
require_once __DIR__."/controllers/RegisterController.php";
require_once __DIR__."/controllers/EmployeeController.php";
require_once __DIR__."/controllers/BillController.php";
require_once __DIR__."/controllers/GuestInfoController.php";

// include validators
require_once __DIR__."/validators/Validator.php";
require_once __DIR__."/validators/RegisterValidator.php";
require_once __DIR__."/validators/EmployeeValidator.php";
require_once __DIR__."/validators/MenuItemValidator.php";
require_once __DIR__."/validators/UserValidator.php";
require_once __DIR__."/validators/GuestInfoValidator.php";
