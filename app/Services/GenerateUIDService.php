<?php

namespace App\Services;

use App\Models\Person;

class GenerateUIDService {
    public function call($uid=null)
    {
        do{
            $uid = rand(00001, 99999);

        }while(Person::isExistingUID($uid));

        return $uid;
    }
}
