<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminHomeTest extends TestCase
{
    /** @test */
    public function homeRouteShouldOnlyBeAccessedByAuthenticatedUsers()
    {
        $response=$this->get(route('home'));
        $response->assertForbidden();
    }

    /** @test */
    public function homeRouteShouldRespondAView()
    {
        $user=User::factory()->create();
        $response=$this->actingAs($user)->get(route('home'));
        $response->assertViewIs('admin.home');

    }
}
