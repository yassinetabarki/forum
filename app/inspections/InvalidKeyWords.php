<?php

namespace App\Inspections;

use Exception;


class InvalidKeyWords{


protected $keywords = [
    'yahoo customer support',
];

    public function detect($body){
    
        foreach ($this->keywords as $keyword) {
            
            if(stripos($body ,$keyword) !== false){

                throw new Exception('your reply contains spam');

            }
        }
    }

    
}