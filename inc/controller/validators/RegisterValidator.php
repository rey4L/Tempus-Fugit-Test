<?php

class RegisterValidator extends Validator {
  
    public function validateNumberOfItems($amount, $stockCount) {
        if($amount > $stockCount) 
            return false;
        return true;
    }
}