<?php

declare(strict_types=1);

use App\Livewire\Team\CreateModal;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

describe('Team Routes', function () {
    it('shows create team button on seasons page', function () {
        $this->actingAs(User::factory()->create());
        $season = Season::factory()->create();

        $this->get(route('season.show', $season))
            ->assertOk()
            ->assertSee('Add team');
    });
});

describe('Team Create Modal', function () {
    it('can create team on season page', function () {
        $user = User::factory()->create();
        $season = Season::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateModal::class, ['season' => $season])
            ->set('form.name', 'Smith')
            ->set('form.division', '10U')
            ->call('save')
            ->assertHasNoErrors();

        expect($season->teams()->count())->toBe(1);
    });

    it('prevents creating duplicate team in same season', function () {
        $user = User::factory()->create();
        $season = Season::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateModal::class, ['season' => $season])
            ->set('form.name', 'Smith')
            ->set('form.division', '10U')
            ->call('save')
            ->assertHasNoErrors();

        Livewire::actingAs($user)
            ->test(CreateModal::class, ['season' => $season])
            ->set('form.name', 'Smith')
            ->set('form.division', '10U')
            ->call('save')
            ->assertHasErrors()
            ->assertSee('This team already exists in this season.');

        expect($season->teams()->count())->toBe(1);
    });
});

describe('Team Model Relationships', function () {
    it('belongs to season', function () {
        $season = Season::factory()->create();
        $team = Team::factory()->create(['season_id' => $season->id]);

        expect($team->season)->tobeInstanceOf(Season::class)
            ->and($team->season->id)->toBe($season->id);
    });
});
