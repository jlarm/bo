<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Organization Settings Routes', function () {
    it('redirects guests to login page', function () {
        $this->get('/organization-settings')->assertRedirect('/login');
    });

    it('allows authenticated users to see organization settings page', function () {
        $this->actingAs(User::factory()->create());

        $this->get('/organization-settings')
            ->assertStatus(200)
            ->assertSee('Organization Settings');
    });
});

describe('Organization Model Factory', function () {
    it('can be created with factory', function () {
        $organization = Organization::factory()->create();

        expect($organization)->toBeInstanceOf(Organization::class)
            ->and($organization->uuid)->toBeString()
            ->and($organization->name)->toBeString()
            ->and($organization->address)->toBeString()
            ->and($organization->city)->toBeString()
            ->and($organization->state)->toBeString()
            ->and($organization->zip_code)->toBeString();
    });

    it('has correct fillable attributes', function () {
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
});

describe('Organization Observer', function () {
    it('automatically generates uuid when creating', function () {
        $organization = Organization::factory()->make(['uuid' => null]);

        expect($organization->uuid)->toBeNull();

        $organization->save();

        expect($organization->uuid)->toBeString()
            ->and($organization->uuid)->toHaveLength(36);
    });

    it('generates uuid on creating through observer', function () {
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
});

describe('Organization Model Casts', function () {
    it('casts uuid to string', function () {
        $organization = Organization::factory()->create();

        expect($organization->getCasts()['uuid'])->toBe('string');
    });
});

describe('Organization::current() method', function () {
    it('returns first organization when one exists', function () {
        $organization = Organization::factory()->create();

        $current = Organization::current();

        expect($current)->toBeInstanceOf(Organization::class)
            ->and($current->id)->toBe($organization->id);
    });

    it('returns null when no organization exists', function () {
        expect(Organization::current())->toBeNull();
    });
});

describe('Organization::currentOrDefault() method', function () {
    it('returns existing organization when one exists', function () {
        $organization = Organization::factory()->create();

        $current = Organization::currentOrDefault();

        expect($current)->toBeInstanceOf(Organization::class)
            ->and($current->id)->toBe($organization->id);
    });

    it('creates new organization when none exists', function () {
        expect(Organization::count())->toBe(0);

        $organization = Organization::currentOrDefault();

        expect(Organization::count())->toBe(1)
            ->and($organization)->toBeInstanceOf(Organization::class)
            ->and($organization->name)->toBe(config('app.name', 'Baseball Organization'))
            ->and($organization->address)->toBe('')
            ->and($organization->city)->toBe('')
            ->and($organization->state)->toBe('')
            ->and($organization->zip_code)->toBe('')
            ->and($organization->logo_path)->toBe('');
    });
});

describe('Organization::createOrUpdate() method', function () {
    it('creates new organization when none exists', function () {
        $data = [
            'name' => 'New Organization',
            'address' => '123 Main St',
            'city' => 'Test City',
            'state' => 'TS',
            'zip_code' => '12345',
        ];

        expect(Organization::count())->toBe(0);

        $organization = Organization::createOrUpdate($data);

        expect(Organization::count())->toBe(1)
            ->and($organization->name)->toBe('New Organization')
            ->and($organization->address)->toBe('123 Main St')
            ->and($organization->city)->toBe('Test City')
            ->and($organization->state)->toBe('TS')
            ->and($organization->zip_code)->toBe('12345');
    });

    it('updates existing organization when one exists', function () {
        $existing = Organization::factory()->create([
            'name' => 'Old Name',
            'address' => 'Old Address',
        ]);

        $data = [
            'name' => 'Updated Name',
            'address' => 'Updated Address',
        ];

        $organization = Organization::createOrUpdate($data);

        expect(Organization::count())->toBe(1)
            ->and($organization->id)->toBe($existing->id)
            ->and($organization->name)->toBe('Updated Name')
            ->and($organization->address)->toBe('Updated Address');
    });

    it('works correctly with single organization constraint', function () {
        // First call should create organization
        $data1 = [
            'name' => 'Initial Organization',
            'address' => '123 Initial St',
            'city' => 'Initial City',
            'state' => 'IS',
            'zip_code' => '11111',
        ];

        $org1 = Organization::createOrUpdate($data1);

        expect(Organization::count())->toBe(1)
            ->and($org1->name)->toBe('Initial Organization');

        // Second call should update existing organization (not create new one)
        $data2 = [
            'name' => 'Updated Organization',
            'address' => '456 Updated St',
            'city' => 'Updated City',
            'state' => 'US',
            'zip_code' => '22222',
        ];

        $org2 = Organization::createOrUpdate($data2);

        expect(Organization::count())->toBe(1)
            ->and($org2->id)->toBe($org1->id)
            ->and($org2->name)->toBe('Updated Organization')
            ->and($org2->address)->toBe('456 Updated St');
    });
});

describe('Organization Logo URL Accessor', function () {
    it('returns null when no logo_path is set', function () {
        $organization = Organization::factory()->create(['logo_path' => null]);

        expect($organization->logo_url)->toBeNull();
    });

    it('returns null when logo_path is empty', function () {
        $organization = Organization::factory()->create(['logo_path' => '']);

        expect($organization->logo_url)->toBeNull();
    });

    it('returns storage url when logo_path is set', function () {
        $organization = Organization::factory()->create(['logo_path' => 'logos/test-logo.png']);

        expect($organization->logo_url)->toBe(Illuminate\Support\Facades\Storage::url('logos/test-logo.png'));
    });
});

describe('Organization Display Name Accessor', function () {
    it('returns name when set', function () {
        $organization = Organization::factory()->create(['name' => 'Test Organization']);

        expect($organization->display_name)->toBe('Test Organization');
    });

    it('returns config app name when name is empty', function () {
        $organization = Organization::factory()->create(['name' => '']);

        expect($organization->display_name)->toBe(config('app.name', 'Baseball Organization'));
    });

    it('returns config app name when name is null', function () {
        $organization = new Organization([
            'uuid' => 'test-uuid',
            'name' => null,
            'address' => '123 Test St',
            'city' => 'Test City',
            'state' => 'TS',
            'zip_code' => '12345',
            'logo_path' => '',
        ]);

        expect($organization->display_name)->toBe(config('app.name', 'Baseball Organization'));
    });
});

describe('Single Organization Constraint', function () {
    it('allows only one organization to be created', function () {
        $org1 = Organization::factory()->create(['name' => 'First Organization']);

        expect(Organization::count())->toBe(1)
            ->and($org1->name)->toBe('First Organization');

        // The factory->create() will fail with the observer constraint
        $org2 = Organization::factory()->make(['name' => 'Second Organization']);
        $result = $org2->save();

        expect($result)->toBeFalse()
            ->and(Organization::count())->toBe(1);
    });

    it('prevents factory create when organization already exists', function () {
        // Create first organization
        Organization::factory()->create(['name' => 'First Organization']);

        expect(Organization::count())->toBe(1);

        // Try to create second organization - should fail
        $org2 = Organization::factory()->make(['name' => 'Second Organization']);
        $result = $org2->save();

        expect($result)->toBeFalse()
            ->and(Organization::count())->toBe(1)
            ->and(Organization::first()->name)->toBe('First Organization');
    });

    it('prevents direct model create when organization already exists', function () {
        // Create first organization
        Organization::create([
            'name' => 'First Organization',
            'address' => '123 First St',
            'city' => 'First City',
            'state' => 'FS',
            'zip_code' => '11111',
        ]);

        expect(Organization::count())->toBe(1);

        // Try to create second organization directly
        $org2 = new Organization([
            'name' => 'Second Organization',
            'address' => '456 Second St',
            'city' => 'Second City',
            'state' => 'SS',
            'zip_code' => '22222',
        ]);

        $result = $org2->save();

        expect($result)->toBeFalse()
            ->and(Organization::count())->toBe(1)
            ->and(Organization::first()->name)->toBe('First Organization');
    });
});
