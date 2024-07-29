<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

// write test to register a user
it('can register a user', function () {
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123ASD@#',
    ]);

    $response->assertStatus(201)
        ->assertJson(fn(\Illuminate\Testing\Fluent\AssertableJson $json) => $json
            ->where('message', 'User registered successfully')
            ->etc());
});

// write test to login a user
it('can login a user', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['message', 'data']);
});

// write test to logout a user
it('can logout a user', function () {
    $response = $this->actingAs($this->user)->postJson('/api/auth/logout');

    $response->assertStatus(200)
        ->assertJson(['message' => 'User Logged Out Successfully']);
});

// write test to check if a user is authenticated
it('can check if a user is authenticated', function () {
    $response = $this->actingAs($this->user)->getJson('/api/user');

    $response->assertStatus(200)
        ->assertJsonStructure(['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']);
});

// write test to check if a user is not authenticated
it('can check if a user is not authenticated', function () {
    $response = $this->getJson('/api/user');

    $response->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});

// write a validation test for AuthController@register
it('validates registration data', function () {
    $response = $this->postJson('/api/auth/register', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'email', 'password']);
});

// write a validation test for AuthController@login
it('validates login data', function () {
    $response = $this->postJson('/api/auth/login', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
});

// write a validation test for AuthController@logout
it('validates logout data', function () {
    $response = $this->postJson('/api/auth/logout');

    $response->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});

// write a validation test for AuthController@user
it('validates user data', function () {
    $response = $this->getJson('/api/user');

    $response->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});

// write a test to check if a user can register with an existing email
it('checks if a user can register with an existing email', function () {
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Test User',
        'email' => $this->user->email,
        'password' => 'password',
//        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

// write a test to check if a user can login with invalid credentials
it('checks if a user can login with invalid credentials', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => $this->user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(400)
        ->assertJson(['message' => 'Invalid login credentials']);
});


