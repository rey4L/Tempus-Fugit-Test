<?php

// basically validate more or less the same things as employee
class UserValidator extends Validator
{

    public function validatePassword($password) {
   
        $minLength = 8;
   
        if (strlen($password) < $minLength) {
            return false;
        }
 
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
    
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            return false;
        }

        return true;
    }

    public function verifyPassword($password,$con_pass){
        return ($password != $con_pass) ? false : true;
    }

    public function validateRole($role) {
        $roles = ['manager', 'cashier'];
        return in_array($role, $roles);
    }

}