<?php

class Validator {

    function sanitize(...$inputs) {
        $sanitized = [];
        foreach($inputs as $input) {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            array_push($sanitized, $input);
        }

        return count($sanitized) === 1 ? $sanitized[0] : $sanitized;
    }

    public function validateTags($otherNames) {
        if (empty($otherNames)) return true;
        if (!$this->isString($otherNames)) false;
        $pattern = '/^(\w+,)*\w+$/';
        return preg_match($pattern, $otherNames) === 1;
    }

    public function isString($input){
        return !empty($input) && is_string($input);
    }

    public function isInt($input){
        return filter_var($input, FILTER_VALIDATE_INT) !== false;
    }

    public function isFloat($input){
        return filter_var($input, FILTER_VALIDATE_FLOAT) !== false;
    }

    public function isNumber($input){
        return $this->isInt($input) || $this->isFloat($input);
    }

    public function isEmail($input){
        return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validateDate($dob) {
        $validDob = date_create_from_format('Y-d-m', $dob);
        return $validDob !== false;
    }


}