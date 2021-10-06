<?php

namespace App\Observers;

use App\Models\Person;

class PersonObserver
{
    /**
     * Handle the Person "created" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function created(Person $person)
    {
        //
    }

    public function creating(Person $person)
    {
        $person->uid = Person::generateUniqueIdentifier();
    }

    /**
     * Handle the Person "updated" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function updated(Person $person)
    {
        //
    }

    /**
     * Handle the Person "deleted" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function deleted(Person $person)
    {
        //
    }

    /**
     * Handle the Person "restored" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function restored(Person $person)
    {
        //
    }

    /**
     * Handle the Person "force deleted" event.
     *
     * @param  \App\Models\Person  $person
     * @return void
     */
    public function forceDeleted(Person $person)
    {
        //
    }
}
