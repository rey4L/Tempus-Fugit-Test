<?php

// Include the common interface and base controller
require __DIR__."/Controller.php";
require __DIR__."/BaseController.php";

// Include traits
require __DIR__."/controllers/common/SearchAndFilter.php";

// Include specific controllers
require __DIR__."/controllers/ErrorController.php";
require __DIR__."/controllers/UserController.php";
require __DIR__."/controllers/MenuItemController.php";
require __DIR__."/controllers/RegisterController.php";
require __DIR__."/controllers/EmployeeController.php";
require __DIR__."/controllers/BillController.php";
require __DIR__."/controllers/GuestInfoController.php";

// include validators
require __DIR__."/validators/Validator.php";
require __DIR__."/validators/RegisterValidator.php";
require __DIR__."/validators/EmployeeValidator.php";
require __DIR__."/validators/MenuItemValidator.php";
require __DIR__."/validators/UserValidator.php";



