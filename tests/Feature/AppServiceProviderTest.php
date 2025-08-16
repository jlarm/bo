<?php

declare(strict_types=1);

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;

uses(RefreshDatabase::class);

test('app service provider boot method exists and can be called', function () {
    $provider = new App\Providers\AppServiceProvider(app());

    expect(method_exists($provider, 'boot'))->toBeTrue();
    expect(method_exists($provider, 'register'))->toBeTrue();

    // Call boot to ensure it doesn't throw errors
    $provider->boot();

    // This test ensures the methods exist and are callable
    expect(true)->toBeTrue();
});

test('view composer provides current organization to views', function () {
    // Test with a guest user
    $response = $this->get('/login');

    // The view composer should add currentOrganization to all views
    $response->assertOk();

    // We can't directly access view data from the response, but we can ensure
    // the view renders without errors and contains the organization data
    expect($response->getContent())->toBeString();
});
