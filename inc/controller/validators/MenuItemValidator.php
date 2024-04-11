<?php 

class MenuItemValidator extends Validator {
    
    function validateDiscount($discount) {
        if ($discount < 0 || $discount > 1) {
            return false;
        }
        return true;
    }
    
}