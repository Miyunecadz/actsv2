<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterBusinessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canRegisterABusiness()
    {
        $user=User::factory()->create();

        $response=$this->actingAs($user)->get(route('businesses.create'));

        $response
            ->assertOk()
            ->assertViewIs('business.create');

    }

     /** @test */
     public function registerBusinessIsNotAcccessibleToGuestUsers()
     {
         $response=$this->get(route('businesses.create'));
 
         $response->assertForbidden();
     }

     /** @test */
     public function businessInformationCanBeStored()
     {
        $user=User::factory()->create();

         $response=$this->actingAs($user)->post(route('businesses.store'),[
             'username'=>'armanbotica',
             'password'=>'123',
             'name'=>'Arman Botica'
         ]);
 
         $response
            ->assertRedirect(route('businesses.index'))
            ->assertSessionHas('created','Business was registered successfully!');

        $this->assertDatabaseCount('businesses',1);

     }

      /** @test */
      public function storingBusinessInfoCannotBeAccessedByGuests()
      {

          $response=$this->post(route('businesses.store'),[
              'username'=>'armanbotica',
              'password'=>'123',
              'name'=>'Arman Botica'
          ]);
  
          $response->assertForbidden();
          $this->assertDatabaseCount('businesses',0);
 
      }


      /** @test */
      public function shouldFailIfUserNameIsNotProvided()
      {
            $user=User::factory()->create();

            $response=$this->actingAs($user)->post(route('businesses.store'),[
                'username'=>'',
                'password'=>'123',
                'name'=>'Arman Botica'
            ]);

            $response
                ->assertRedirect(route('businesses.create'))
                ->assertSessionHasErrors([
                    'username'
                ]);
 
      }

      /**
       * TODO: 
       * 1. create test to ensure password is hashed
       * 2. password must be required
       * 3. username must be unique
       * 4. name must be unique
       * 5. name must be required
       */

}