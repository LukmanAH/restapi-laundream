<?php

namespace Tests\Feature;

use App\Models\Laundry;
use App\Models\Parfume;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParfumeControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_owner_can_see_all_parfumes()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();
        $parfumes = Parfume::factory()->for($laundry)->count(3)->create();

        $response = $this->getJson("/api/v1/owner/laundries/{$laundry->id}/parfumes");

        $response->assertOk()
            ->assertJsonCount(3);
    }

    public function test_owner_can_see_all_parfumes_where_belong_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();
        Parfume::factory()->for($laundry)->count(3)->create();

        Parfume::factory()->count(4)->create();

        $response = $this->getJson("/api/v1/owner/laundries/{$laundry->id}/parfumes");

        $response->assertOk()
            ->assertJsonCount(3);
    }

    public function test_owner_cannot_see_parfumes_if_not_belong_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->create();

        $response = $this->getJson("/api/v1/owner/laundries/{$laundry->id}/parfumes");

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['parfume' => 'Tidak dapat melihat parfum!']);
    }

    public function test_owner_cannot_see_parfumes_if_scope_not_provided()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner, []);

        $laundry = Laundry::factory()->create();

        $response = $this->getJson("/api/v1/owner/laundries/{$laundry->id}/parfumes");

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['parfume' => 'Tidak dapat melihat parfum!']);
    }

    public function test_owner_can_make_parfume()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();

        $response = $this->postJson(
            "/api/v1/owner/laundries/{$laundry->id}/parfumes",
            [
                'name' => 'Parfume'
            ]
        );

        $response->assertCreated()
            ->assertJsonPath('name', 'Parfume');
    }

    public function test_owner_cannot_make_parfume_if_not_belong_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->create();

        $response = $this->postJson(
            "/api/v1/owner/laundries/{$laundry->id}/parfumes",
            [
                'name' => 'Parfume'
            ]
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['parfume' => 'Tidak dapat membuat parfum!']);
    }

    public function test_owner_cannot_make_parfume_if_scope_not_provided()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner, []);

        $laundry = Laundry::factory()->create();

        $response = $this->postJson(
            "/api/v1/owner/laundries/{$laundry->id}/parfumes",
            [
                'name' => 'Parfume'
            ]
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['parfume' => 'Tidak dapat membuat parfum!']);
    }

    public function test_owner_can_update_parfume()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();
        $parfume = Parfume::factory()->for($laundry)->create();

        $response = $this->putJson(
            "/api/v1/owner/laundries/{$laundry->id}/parfumes/{$parfume->id}",
            [
                'name' => 'Parfume'
            ]
        );

        $response->assertOk()
            ->assertJsonPath('name', 'Parfume');
    }

    public function test_owner_cannot_update_parfume_if_not_belong_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();
        $parfume = Parfume::factory()->create();

        $response = $this->putJson(
            "/api/v1/owner/laundries/{$laundry->id}/parfumes/{$parfume->id}",
            [
                'name' => 'Parfume'
            ]
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['parfume' => 'Tidak dapat mengubah parfum!']);
    }

    public function test_owner_cannot_update_parfume_if_scope_not_provided()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner, []);

        $laundry = Laundry::factory()->for($owner)->create();
        $parfume = Parfume::factory()->create();

        $response = $this->putJson(
            "/api/v1/owner/laundries/{$laundry->id}/parfumes/{$parfume->id}",
            [
                'name' => 'Parfume'
            ]
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['parfume' => 'Tidak dapat mengubah parfum!']);
    }

    public function test_owner_can_delete_parfume()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();
        $parfume = Parfume::factory()->for($laundry)->create();

        $response = $this->deleteJson("/api/v1/owner/laundries/{$laundry->id}/parfumes/{$parfume->id}");

        $response->assertOk();

        $this->assertModelMissing($parfume);
    }

    public function test_owner_cannot_delete_parfume_if_scope_not_provided()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner, []);

        $laundry = Laundry::factory()->for($owner)->create();
        $parfume = Parfume::factory()->for($laundry)->create();

        $response = $this->deleteJson("/api/v1/owner/laundries/{$laundry->id}/parfumes/{$parfume->id}");

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['parfume' => 'Tidak dapat menghapus parfum!']);
    }

    public function test_owner_cannot_delete_parfume_if_not_belong_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();
        $parfume = Parfume::factory()->create();

        $response = $this->deleteJson("/api/v1/owner/laundries/{$laundry->id}/parfumes/{$parfume->id}");

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['parfume' => 'Tidak dapat menghapus parfum!']);
    }
}
