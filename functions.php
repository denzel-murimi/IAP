<?php
class fnc{
    var $name;
    public $yob;
    public $fname;
    protected $username;
    private $password;

    public function computer_user($fname){
        return $fname;
    }

    public function user_age($fname,$yob){
        $user=$this->computer_user($fname);
        $age=date('Y')-$yob;
        return $user." is ".  $age;
    }
}

$Obj=new fnc();

