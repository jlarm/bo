<?php

declare(strict_types=1);

use App\Livewire\Season\CreateModal;
use App\Livewire\Season\Index;
use App\Models\Season;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/seasons')->assertRedirect('/login');
});

test('authenticated users can see the seasons page', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/seasons')
        ->assertOk()
        ->assertSeeLivewire(Index::class);
});

test('season form creates season with correct name format', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateModal::class)
        ->set('form.season', 'winter')
        ->set('form.year', '2025')
        ->call('save')
        ->assertHasNoErrors();

    expect(Season::where('name', 'Winter 2025')->exists())->toBeTrue();
});

test('create modal displays validation error for duplicate season', function () {
    $user = User::factory()->create();
    Season::factory()->create(['name' => 'Spring 2024']);

    Livewire::actingAs($user)
        ->test(CreateModal::class)
        ->set('form.season', 'spring')
        ->set('form.year', '2024')
        ->call('save')
        ->assertHasErrors('form.season')
        ->assertSee('This season already exists.');
});

test('create modal successfully creates unique season', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CreateModal::class)
        ->set('form.season', 'spring')
        ->set('form.year', '2024')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('season.created');

    expect(Season::where('name', 'Spring 2024')->exists())->toBeTrue();
});

test('season model casts attributes correctly', function () {
    $season = Season::factory()->create([
        'uuid' => 'test-uuid',
        'archived' => true,
    ]);

    expect($season->uuid)->toBeString();
    expect($season->archived)->toBeBool();
    expect($season->archived)->toBeTrue();
});

test('season model orders by season and year correctly', function () {
    Season::factory()->create(['name' => 'Spring 2024', 'archived' => false]);
    Season::factory()->create(['name' => 'Fall 2023', 'archived' => false]);
    Season::factory()->create(['name' => 'Winter 2024', 'archived' => false]);
    Season::factory()->create(['name' => 'Summer 2024', 'archived' => false]);
    Season::factory()->create(['name' => 'Spring 2023', 'archived' => true]);

    $seasons = Season::orderBySeasonAndYear()->get();

    // Should order by archived first (false before true), then by year, then by season order
    expect($seasons->pluck('name')->toArray())->toEqual([
        'Fall 2023',
        'Spring 2024',
        'Summer 2024',
        'Winter 2024',
        'Spring 2023',
    ]);
});
