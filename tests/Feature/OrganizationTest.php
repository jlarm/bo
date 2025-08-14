<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/organization-settings')->assertRedirect('/login');
});

test('authenticated user can see the organization settings page', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/organization-settings')
        ->assertStatus(200)
        ->assertSee('Organization Settings');
});
