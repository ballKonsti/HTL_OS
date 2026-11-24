<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('guests cannot access the node editor', function () {
    $this->get(route('admin'))
        ->assertRedirect(route('login'));
});

test('guests cannot access the node graph editor', function () {
    $this->get(route('admin.graph'))
        ->assertRedirect(route('login'));
});

test('authenticated users can visit the node graph editor', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.graph'))
        ->assertOk();
});
