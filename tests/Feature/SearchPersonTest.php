<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchPersonTest extends TestCase
{
    use RefreshDatabase;

    private function getUser()
    {
        return User::factory()->create();
    }
    /** @test */
    public function canSearchAPersonByFirstname()
    {
        $person=Person::factory()->create([
            'firstname'=>'Arman'
        ]);

        Person::factory()->create();

        $response=$this->actingAs($this->getUser())->get(route('persons.search',[
            'keyword'=>'Arman'
        ]));

        $response
            ->assertViewIs('person.search-results')
            ->assertViewHas('persons');
        
        $results=$response['persons'];
    
        $this->assertSame($person->id,$results[0]->id);

    }

    /** @test */
    public function canSearchAPersonByLastname()
    {
        $person=Person::factory()->create([
            'lastname'=>'Masangkay'
        ]);

        Person::factory()->create();

        $response=$this->actingAs($this->getUser())->get(route('persons.search',[
            'keyword'=>'Masangkay'
        ]));

        $response
            ->assertViewIs('person.search-results')
            ->assertViewHas('persons');
        
        $results=$response['persons'];
    
        $this->assertSame($person->id,$results[0]->id);

    }

     /** @test */
     public function canSearchAPersonByBothFirstNameAndLastname()
     {
         $person=Person::factory()->create([
             'firstname'=>'Arman',
             'lastname'=>'Masangkay'
         ]);
 
         Person::factory()->create();
 
         $response=$this->actingAs($this->getUser())->get(route('persons.search',[
             'keyword'=>'Arman Masangkay'
         ]));
 
         $response
             ->assertViewIs('person.search-results')
             ->assertViewHas('persons');
         
         $results=$response['persons'];
     
         $this->assertSame($person->id,$results[0]->id);
 
     }

     /** @test */
     public function canSearchAPersonByBothFirstNameAndLastnameWhereLastnameIsProvidedFirst()
     {
         $person=Person::factory()->create([
             'firstname'=>'Arman',
             'lastname'=>'Masangkay'
         ]);
 
         Person::factory()->create();
 
         $response=$this->actingAs($this->getUser())->get(route('persons.search',[
             'keyword'=>'Masangkay Arman'
         ]));
 
         $response
             ->assertViewIs('person.search-results')
             ->assertViewHas('persons');
         
         $results=$response['persons'];
     
         $this->assertSame($person->id,$results[0]->id);
 
     }

      /** @test */
      public function canSearchWhileIgnoringCases()
      {
          $person=Person::factory()->create([
              'firstname'=>'Arman',
              'lastname'=>'Masangkay'
          ]);
  
          Person::factory()->create();
  
          $response=$this->actingAs($this->getUser())->get(route('persons.search',[
              'keyword'=>'masanGkay arman'
          ]));
  
          $response
              ->assertViewIs('person.search-results')
              ->assertViewHas('persons');
          
          $results=$response['persons'];
      
          $this->assertSame($person->id,$results[0]->id);
  
      }

       /** @test */
       public function searchCannotBeDoneByGuestUsers()
       {
           $person=Person::factory()->create([
               'firstname'=>'Arman',
               'lastname'=>'Masangkay'
           ]);
   
           Person::factory()->create();
   
           $response=$this->get(route('persons.search',[
               'keyword'=>'masanGkay arman'
           ]));
   
           $response->assertForbidden();
   
       }
}
