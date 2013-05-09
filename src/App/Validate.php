<?php

class Validate
{
    public function datasize($input){

    }

    public function integer($input){
        return is_int($input);
    }

    public function ipaddress($input){
        return filter_var($input,FILTER_VALIDATE_IP);
    }

}

?>
