<?php

namespace Tests\Feature\user;

use App\Models\User;
use App\Traits\Route;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use WithoutMiddleware;
    use Route;
    /** @test */
    public function unauthenticated_can_not_see_create_form()
    {
        $response = $this->get($this->getCreateUserRoute());
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }
    /** @test */
    public function authenticated_can_see_create_form()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create());
        $response = $this->get($this->getCreateUserRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.create');
    }

    /** @test */
    public function unauthenticatphed_can_not_create_form()
    {
        $user = User::factory()->make()->toArray();
        $response = $this->post($this->getCreateUserRoute(), $user);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }
}
