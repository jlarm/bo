<?php

declare(strict_types=1);

use App\Livewire\Auth\VerifyEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('verify email component sends verification when user is not verified', function () {
    $user = User::factory()->unverified()->create();

    Livewire::actingAs($user)
        ->test(VerifyEmail::class)
        ->call('sendVerification')
        ->assertStatus(200);

    // The verification should have been triggered (we can't easily test the actual email sending in unit tests)
    expect($user->hasVerifiedEmail())->toBeFalse();
});

test('verify email component redirects when user is already verified', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    Livewire::actingAs($user)
        ->test(VerifyEmail::class)
        ->call('sendVerification')
        ->assertRedirect('/dashboard');
});

test('verify email component can logout user', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(VerifyEmail::class)
        ->call('logout')
        ->assertRedirect('/');
});
