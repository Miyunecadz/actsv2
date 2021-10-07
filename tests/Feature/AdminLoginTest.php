<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function shouldBeAbleToLogin()
    {
        $user=User::factory()->create([
            'username'=>'amasangkay',
            'password'=>Hash::make('12345')
        ]);

        $response=$this->post('login',[
            'username'=>'amasangkay',
            'password'=>'12345'
        ]);

        $this->assertAuthenticatedAs($user);
    }

     /** @test */
     public function shouldHaveErrorIfRequiredFieldsAreNotProvided()
     {
         $user=User::factory()->create([
             'username'=>'amasangkay',
             'password'=>Hash::make('12345')
         ]);
 
         $response=$this->post('login',[
             'username'=>'',
             'password'=>''
         ]);
 
         $response
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors([
                'username',
                'password'
            ]);
     }

      /** @test */
      public function shouldHaveInputsBackIfIncorrectCredentials()
      {
          $user=User::factory()->create([
              'username'=>'amasangkay',
              'password'=>Hash::make('12345')
          ]);
  
          $response=$this->post('login',[
              'username'=>'armanmasangkay',
              'password'=>'123'
          ]);
  
          $response
             ->assertRedirect(route('login'))
             ->assertSessionHasInput('username','armanmasangkay')
             ->assertSessionHasInput('password','123');

      }

       /** @test */
       public function shouldRedirectToHomePageIfCredentialsAreCorrect()
       {
           $user=User::factory()->create([
               'username'=>'amasangkay',
               'password'=>Hash::make('12345')
           ]);
   
           $response=$this->post('login',[
               'username'=>'amasangkay',
               'password'=>'12345'
           ]);
   
           $response
              ->assertRedirect(route('home'));
 
       }
}
