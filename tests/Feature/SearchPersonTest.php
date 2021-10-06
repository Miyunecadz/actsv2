<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchPersonTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function canSearchAPersonByFirstname()
    {
        $person=Person::factory()->create([
            'firstname'=>'Arman'
        ]);

        Person::factory()->create();

        $response=$this->get(route('persons.search',[
            'keyword'=>'Arman'
        ]));

        $response
            ->assertRedirect(route('persons.search-results'))
            ->assertSessionHasAll(['persons']);
    
        $results=session('persons');

        $this->assertSame($person->id,$results[0]->id);

    }
}
