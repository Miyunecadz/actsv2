<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePersonInformationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function updateRouteIsNotAccessibleToGuestUsers()
    {
        $person=Person::factory()->create();

        $response=$this->put(route('persons.update',$person));

        $response->assertForbidden();
    }

      /** @test */
      public function updateRouteIsAccessibleToAuthenticatedUsers()
      {
          $person=Person::factory()->create();

          $user=User::factory()->create();

          $this->actingAs($user);

          $response=$this->put(route('persons.update',$person),[
              'firstname'=>'Arman',
              'lastname'=>'Masangkay',
              'middlename'=>'Macasuhot',
              'address'=>'Malitbog'
          ]);
  
          $response->assertOk();
      }

      /** @test */
      public function shouldUpdatePersonInformation()
      {
          $person=Person::factory()->create();

          $user=User::factory()->create();

          $this->actingAs($user);

          $response=$this->put(route('persons.update',$person),[
              'firstname'=>'Arman',
              'lastname'=>'Masangkay',
              'middlename'=>'Macasuhot',
              'address'=>'Malitbog'
          ]);
  
          $updatedPerson=Person::find($person->id);

          $this->assertSame('Arman',$updatedPerson->firstname);
          $this->assertSame('Masangkay',$updatedPerson->lastname);
          $this->assertSame('Macasuhot',$updatedPerson->middlename);
          $this->assertSame('Malitbog',$updatedPerson->address);
      }

        /** @test */
        public function shouldNotUpdateIfRequiredFieldsAreEmpty()
        {
            $person=Person::factory()->create();
  
            $user=User::factory()->create();
  
            $this->actingAs($user);
  
            $response=$this->put(route('persons.update',$person),[
                'firstname'=>'',
                'lastname'=>'',
                'middlename'=>'Macasuhot',
                'address'=>''
            ]);
    
            $response
                ->assertRedirect(route('persons.edit',$person))
                ->assertSessionHasErrors([
                    'firstname',
                    'lastname',
                    'address'
                ]);
        }

           /** @test */
      public function shouldNotBeAbleToUpdateUid()
      {
          $person=Person::factory()->create();

          $user=User::factory()->create();

          $this->actingAs($user);

          $response=$this->put(route('persons.update',$person),[
              'uid'=>'123',
              'firstname'=>'Arman',
              'lastname'=>'Masangkay',
              'middlename'=>'Macasuhot',
              'address'=>'Malitbog'
          ]);
  
          $updatedPerson=Person::find($person->id);

          $this->assertSame('Arman',$updatedPerson->firstname);
          $this->assertSame('Masangkay',$updatedPerson->lastname);
          $this->assertSame('Macasuhot',$updatedPerson->middlename);
          $this->assertSame('Malitbog',$updatedPerson->address);
          $this->assertNotSame('123',$updatedPerson->uid);
      }


}
