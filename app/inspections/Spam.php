<?php

namespace App\Inspections;

use Exception;

class Spam {
    

    protected $inspections = [
        InvalidKeyWords::class,
        KeyHeldDown::class
    ];

    public function detect($body){
        
        foreach($this->inspections as $inspection){

            app($inspection)->detect($body);
            
        }
        return false;
    }



}
