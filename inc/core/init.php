<?php



// core init
require __DIR__."/config.php";  
require __DIR__."/Router.php";   

// model init
require __DIR__."/../modules/guest_registration/model/initModel.php";      

// controller init
require __DIR__."/../modules/guest_registration/controller/initControllers.php";

require __DIR__."/../modules/room_management/model/initModel.php";      

// controller init
require __DIR__."/../modules/room_management/controller/initControllers.php";

