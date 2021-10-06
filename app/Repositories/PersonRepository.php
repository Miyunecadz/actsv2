<?php namespace App\Repositories;

use App\Models\Person;

class PersonRepository{

    public function create(array $data)
    {
        Person::create([
            'firstname'=>$data['firstname'],
            'lastname'=>$data['lastname'],
            'middlename'=>$data['middlename'],
            'address'=>$data['address'],
        ]);
    }

    public function update(array $data,Person $person)
    {
        $person->firstname=$data['firstname'];
        $person->lastname=$data['lastname'];
        $person->middlename=$data['middlename'];
        $person->address=$data['address'];

        $person->save();
       
    }
}