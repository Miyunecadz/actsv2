<?php namespace App\Repositories;

use App\Models\Person;
use Illuminate\Support\Facades\DB;

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

    public function search($keyword)
    {
        return Person::where('firstname',$keyword)
                    ->orWhere('lastname',$keyword)
                    ->orWhere(DB::raw("CONCAT(firstname,' ',lastname)"),$keyword)
                    ->orWhere(DB::raw("CONCAT(lastname,' ',firstname)"),$keyword)
                    ->get();
    }

    public function delete(Person $person)
    {
        $person->delete();
    }
}