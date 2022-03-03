<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;

use Tests\TestCase;

class EditUserTest extends TestCase
{
    use WithoutMiddleware;
    public function getEditUserRoute($id)
    {
        return route('users.update', $id);
    }
    public function getRedirectUserRoute()
    {
        return route('users.index');
    }

    /** @test */
    public function authenticate_can_edit_user()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '123456', // password
            'password_confirmation' => '123456'
        ];
        $response = $this->put($this->getEditUserRoute($user->id), $data);
        $userCheck = User::find($user->id);
        $this->assertSame($userCheck->name, $data['name']);
        $this->assertSame($userCheck->email, $data['email']);
        $response->assertRedirect($this->getRedirectUserRoute());
    }

    /** @test */

    public function authenticate_can_not_edit_user_if_name_is_null()
    {

        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        $data = [
            'name' => '',
            'email' => $this->faker->unique()->safeEmail(),
            'changePassword' => 'on',
            'password' => '123456', // password
            'password_confirmation' => '123456'
        ];

        $response = $this->put($this->getEditUserRoute($user->id), $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }
       /** @test */

       public function authenticate_can_not_edit_user_if_password_is_null()
       {

           $this->actingAs(User::factory()->create());
           $user = User::factory()->create();
           $data = [
            'name' => $this->faker->name(),
             'email' => $this->faker->unique()->safeEmail(),
             'changePassword' => 'on',
             'password' => '', // password
             'password_confirmation' => '123456'
         ];
           $response = $this->put($this->getEditUserRoute($user->id), $data);
           $response->assertStatus(Response::HTTP_FOUND);
           $response->assertSessionHasErrors(['password']);
       }
}


