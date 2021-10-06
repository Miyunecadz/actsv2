<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StorePersonTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
    */
    public function shouldBeAccessByLoginUsers()
    {
        $response = $this->post(route('persons.store'),[
            'firstname' => "",
            'lastname' => 'Cadayona'
        ]);

        $response->assertForbidden();
    }


    /**
     * @test
    */
    public function firstNameShouldBeRequired()
    {
        $response = $this->actingAs(User::factory()->create())->post(route('persons.store'),[
            'firstname' => "",
            'lastname' => 'Cadayona'
        ]);

        $response->assertRedirect(route('persons.create'));
        $response->assertSessionHasErrors(['firstname']);
        $this->assertDatabaseCount('people', 0);
    }

     /**
     * @test
    */
    public function lastNameShouldBeRequired()
    {
        $response = $this->actingAs(User::factory()->create())->post(route('persons.store'),[
            'firstname' => "JV",
            'lastname' => ''
        ]);

        $response->assertRedirect(route('persons.create'));
        $response->assertSessionHasErrors(['lastname']);
        $this->assertDatabaseCount('people', 0);
    }

     /**
     * @test
    */
    public function middleNameShouldBeOptional()
    {
        $response = $this->actingAs(User::factory()->create())->post(route('persons.store'),[
            'firstname' => "JV",
            'lastname' => 'Cadayona',
            'middlename' => '',
            'address' => 'Somewhere'
        ]);

        $this->assertDatabaseCount('people', 1);
        $response->assertRedirect(route('persons.index'));
        $response->assertSessionHasAll(['created' => true]);
    }

     /**
     * @test
    */
    public function addressShouldBeRequired()
    {
        $response = $this->actingAs(User::factory()->create())->post(route('persons.store'),[
            'firstname' => "JV",
            'lastname' => 'cadz',
            'address' => ''
        ]);

        $response->assertRedirect(route('persons.create'));
        $response->assertSessionHasErrors(['address']);
        $this->assertDatabaseCount('people', 0);
    }

    /**
     * @test
    */
    public function shouldGenerateUniqueIdentifier()
    {
        $response = $this->actingAs(User::factory()->create())->post(route('persons.store'),[
            'firstname' => "JV",
            'lastname' => 'cadz',
            'middlename'=>'',
            'address' => 'somewhere'
        ]);

        $response2 = $this->actingAs(User::factory()->create())->post(route('persons.store'),[
            'firstname' => "JV",
            'lastname' => 'cadz',
            'middlename'=>'',
            'address' => 'somewhere'
        ]);

        $people = Person::all();

        $this->assertDatabaseCount('people', 2);

        $this->assertNotSame($people[0]->uid, $people[1]->uid);
    }

    /**
     * @test
    */
    public function failIfUniqueIdentifierIsNotUnique()
    {

        $response = $this->actingAs(User::factory()->create())->post(route('persons.store'),[
            'firstname' => "JV",
            'lastname' => 'cadz',
            'middlename'=>'',
            'address' => 'somewhere'
        ]);

        $response2 = $this->actingAs(User::factory()->create())->post(route('persons.store'),[
            'firstname' => "JV",
            'lastname' => 'cadz',
            'middlename'=>'',
            'address' => 'somewhere'
        ]);

        $people = Person::all();

        $this->assertDatabaseCount('people', 2);
        try{
            $people[0]->uid = $people[1]->uid;
            $people[0]->save();
        }catch(Exception $e){

            $this->assertStringContainsString('1062', $e->getMessage());

        }

    }

    /**
     * @test
    */
    public function shouldGenerateUidNotBeingUsed()
    {
        $person = Person::create([
            'firstname' => "JV",
            'lastname' => 'cadz',
            'address' => 'somewhere'
        ]);


        $uid =  Person::generateUniqueIdentifier($person->uid);

        $this->assertNotSame($person->uid, $uid);

    }
}
