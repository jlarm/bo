<?php

declare(strict_types=1);

use App\Livewire\Season\Index;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/seasons')->assertRedirect('/login');
});

test('authenticated users can see the seasons page', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/seasons')
        ->assertOk()
        ->assertSeeLivewire(Index::class);
});
