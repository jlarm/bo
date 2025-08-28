<?php

declare(strict_types=1);

use App\Http\Requests\SeasonRequest;
use App\Livewire\Season\CreateModal;
use App\Livewire\Season\Index;
use App\Livewire\Season\IndexItem;
use App\Models\Season;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

describe('Season Routes', function () {
    it('redirects guests to login page', function () {
        $this->get('/seasons')->assertRedirect('/login');
    });

    it('allows authenticated users to see seasons page', function () {
        $this->actingAs(User::factory()->create());

        $this->get('/seasons')
            ->assertOk()
            ->assertSeeLivewire(Index::class);
    });
});

describe('Season Create Modal', function () {
    it('creates season with correct name format', function () {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateModal::class)
            ->set('form.season', 'winter')
            ->set('form.year', '2025')
            ->call('save')
            ->assertHasNoErrors();

        expect(Season::where('name', 'Winter 2025')->exists())->toBeTrue();
    });

    it('displays validation error for duplicate season', function () {
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

    it('successfully creates unique season', function () {
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
});

describe('Season Model', function () {
    it('casts attributes correctly', function () {
        $season = Season::factory()->create([
            'uuid' => 'test-uuid',
        ]);

        expect($season->uuid)->toBeString();
    });

    it('orders by season and year correctly', function () {
        Season::factory()->create(['name' => 'Spring 2024']);
        Season::factory()->create(['name' => 'Fall 2023']);
        Season::factory()->create(['name' => 'Winter 2024']);
        Season::factory()->create(['name' => 'Summer 2024']);

        $seasons = Season::orderBySeasonAndYear()->get();

        // Should order by year first, then by season order (Spring, Summer, Fall, Winter)
        expect($seasons->pluck('name')->toArray())->toEqual([
            'Fall 2023',
            'Spring 2024',
            'Summer 2024',
            'Winter 2024',
        ]);
    });
});

describe('Season Soft Deletes', function () {
    it('supports soft deletes', function () {
        $season = Season::factory()->create(['name' => 'Test Season 2024']);

        expect($season->deleted_at)->toBeNull();

        $season->delete();

        expect($season->refresh()->deleted_at)->not->toBeNull();
        expect(Season::where('name', 'Test Season 2024')->exists())->toBeFalse();
        expect(Season::withTrashed()->where('name', 'Test Season 2024')->exists())->toBeTrue();
    });

    it('excludes soft deleted seasons from normal queries', function () {
        $activeSeason = Season::factory()->create(['name' => 'Active Season 2024']);
        $deletedSeason = Season::factory()->create(['name' => 'Deleted Season 2024']);

        $deletedSeason->delete();

        $seasons = Season::all();

        expect($seasons)->toHaveCount(1);
        expect($seasons->first()->name)->toBe('Active Season 2024');
    });

    it('can restore soft deleted seasons', function () {
        $season = Season::factory()->create(['name' => 'Restorable Season 2024']);
        $season->delete();

        expect(Season::where('name', 'Restorable Season 2024')->exists())->toBeFalse();

        $season->restore();

        expect(Season::where('name', 'Restorable Season 2024')->exists())->toBeTrue();
        expect($season->refresh()->deleted_at)->toBeNull();
    });
});

describe('Season Request Validation', function () {
    it('validates data correctly', function () {
        $request = new SeasonRequest();

        $rules = $request->rules();

        expect($rules)->toHaveKey('uuid');
        expect($rules)->toHaveKey('name');
        expect($rules['uuid'])->toContain('required');
        expect($rules['name'])->toContain('required', 'string', 'min:3', 'max:255');
    });

    it('authorizes all requests', function () {
        $request = new SeasonRequest();

        expect($request->authorize())->toBeTrue();
    });
});

describe('Season Index Item Component', function () {
    it('can archive season', function () {
        $user = User::factory()->create();
        $season = Season::factory()->create(['name' => 'Test Season 2024']);

        Livewire::actingAs($user)
            ->test(IndexItem::class, ['season' => $season])
            ->call('archive')
            ->assertDispatched('season.archived');

        expect($season->fresh()->deleted_at)->not->toBeNull();
    });

    it('renders correctly', function () {
        $user = User::factory()->create();
        $season = Season::factory()->create(['name' => 'Test Season 2024']);

        $component = Livewire::actingAs($user)
            ->test(IndexItem::class, ['season' => $season]);

        expect($component->get('season')->name)->toBe('Test Season 2024');
    });
});
