<?php

namespace Tests\Feature\user;
use App\Models\User;
use App\Traits\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowUserTest extends TestCase
{
    use Route;
    /** @test */
    public function authenticated_can_get_list_user()
    {
        // $this->actingAs(User::factory()->create());
        $user = User::factory()->create();
        $response = $this->get($this->getListUserRoute());
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.index');
        // $response->assertSee($user->name);
        // $response->assertRedirect('/login');

    }

    /** @test */
    public function authenticated_can_show_a_user()
    {
        $user = User::factory()->create();
        $response = $this->get($this->getShowUserRoute($user->id));
        $response->assertViewIs('users.show');
        $response->assertStatus(Response::HTTP_OK);
        // $response->assertSee($user->name);
    }
}
