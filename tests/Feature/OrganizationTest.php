<?php

declare(strict_types=1);

use App\Models\Organization;
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

test('organization can be created with factory', function () {
    $organization = Organization::factory()->create();

    expect($organization)->toBeInstanceOf(Organization::class)
        ->and($organization->uuid)->toBeString()
        ->and($organization->name)->toBeString()
        ->and($organization->address)->toBeString()
        ->and($organization->city)->toBeString()
        ->and($organization->state)->toBeString()
        ->and($organization->zip_code)->toBeString();
});

test('organization uuid is automatically generated when creating', function () {
    $organization = Organization::factory()->make(['uuid' => null]);

    expect($organization->uuid)->toBeNull();

    $organization->save();

    expect($organization->uuid)->toBeString()
        ->and($organization->uuid)->toHaveLength(36);
});

test('organization observer generates uuid on creating', function () {
    $organization = new Organization([
        'name' => 'Test Organization',
        'address' => '123 Test St',
        'city' => 'Test City',
        'state' => 'TS',
        'zip_code' => '12345',
    ]);

    expect($organization->uuid)->toBeNull();

    $organization->save();

    expect($organization->uuid)->toBeString()
        ->and($organization->uuid)->toHaveLength(36);
});

test('organization has correct fillable attributes', function () {
    $organization = Organization::factory()->create([
        'name' => 'Updated Organization',
        'address' => 'Updated Address',
        'city' => 'Updated City',
        'state' => 'UP',
        'zip_code' => '54321',
        'logo_path' => '/path/to/logo.png',
    ]);

    expect($organization->name)->toBe('Updated Organization')
        ->and($organization->address)->toBe('Updated Address')
        ->and($organization->city)->toBe('Updated City')
        ->and($organization->state)->toBe('UP')
        ->and($organization->zip_code)->toBe('54321')
        ->and($organization->logo_path)->toBe('/path/to/logo.png');
});

test('organization casts uuid to string', function () {
    $organization = Organization::factory()->create();

    expect($organization->getCasts()['uuid'])->toBe('string');
});
