<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use App\Repositories\PersonRepository;

class PersonController extends Controller
{

    protected PersonRepository $repository;

    public function __construct(PersonRepository $repository)
    {
        $this->repository=$repository;  
    }
  
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(StorePersonRequest $request)
    {
        $this->repository->create($request->all());

        return redirect(route('persons.index'))->with(['created' => true]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(UpdatePersonRequest $request, Person $person)
    {
        $this->repository->update($request->all(),$person);
    }


    public function destroy($id)
    {
        //
    }
}
