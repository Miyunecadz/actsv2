<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePersonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canDeleteAPerson()
    {
        $user=User::factory()->create();
        
        $person=Person::factory()->create();

        $response=$this->actingAs($user)->delete(route('persons.destroy',$person));

        $response
            ->assertRedirect(route('persons.index'))
            ->assertSessionHas('deleted','Person was deleted successfully!');

        $this->assertDatabaseCount('people',0);

    }

     /** @test */
     public function cannotBeAccessedByGuestUsers()
     {
         
         $person=Person::factory()->create();
 
         $response=$this->delete(route('persons.destroy',$person));
 
         $response->assertForbidden();
        
     }


}
