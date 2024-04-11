<?php 

class GuestInfoValidator extends Validator {
    
    public function validateGender($gender) {
        $validGenders = ['Male','Female', 'Other'];
        return in_array($gender, $validGenders);
    }

    public function validateAge($age) {
        if (!$this->isInt($age)) return false;
        return  filter_var($age, 
                FILTER_VALIDATE_INT, 
                ['options' => ['min_range' => 18, 'max_range' => 70]]);
    }

    public function validateDobAndAge($dob, $age) {
        return $this->calculateAge($dob) == $age;
    }

    function validatePhoneNumber($number) {
        return strlen($number) === 7 ? true : false;
    }

    private function calculateAge($dob) {
        $dobDate = new DateTime($dob);
        $currentDate = new DateTime();
        $ageInterval = $dobDate->diff($currentDate);
        return $ageInterval->y;
    }
}