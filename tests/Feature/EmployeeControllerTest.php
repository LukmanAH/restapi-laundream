<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Laundry;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_owner_can_see_all_employee()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();
        Employee::factory()->for($laundry)->count(5)->create();

        $response = $this->getJson("/api/v1/owner/laundries/{$laundry->id}/employees");

        $response->assertOk()
            ->assertJsonCount(5);
    }

    public function test_owner_cannot_see_employees_where_not_belongs_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        Laundry::factory()->for($owner)->create();

        $laundry2 = Laundry::factory()->create();

        $response = $this->getJson("/api/v1/owner/laundries/{$laundry2->id}/employees");

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['employee' => 'Tidak dapat melihat karyawan!']);
    }

    public function test_user_not_allowed_to_see_employee()
    {
        $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);
        $this->actingAs($customer, []);

        $laundry = Laundry::factory()->create();
        Employee::factory()->for($laundry)->count(5)->create();

        $response = $this->getJson("/api/v1/owner/laundries/{$laundry->id}/employees");

        $response->assertUnprocessable();
    }

    public function test_owner_can_make_employee()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();

        $response = $this->postJson(
            "/api/v1/owner/laundries/{$laundry->id}/employees",
            [
                'email' => 'e@email.com',
                'password' => '123',
                'name' => 'Employee',
                'no_hp' => '0821242'
            ]
        );

        $response->assertCreated()
            ->assertJsonPath('email', 'e@email.com');
    }

    public function test_user_cannot_make_employee_if_scope_not_provided()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner, []);

        $laundry = Laundry::factory()->create();

        $response = $this->postJson(
            "/api/v1/owner/laundries/{$laundry->id}/employees",
            [
                'email' => 'e@email.com',
                'password' => '123',
                'name' => 'Employee',
                'no_hp' => '0821242'
            ]
        );

        $response->assertForbidden();
    }

    public function test_owner_cannot_make_employee_if_not_belong_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->create();

        $response = $this->postJson(
            "/api/v1/owner/laundries/{$laundry->id}/employees",
            [
                'email' => 'e@email.com',
                'password' => '123',
                'name' => 'Employee',
                'no_hp' => '0821242'
            ]
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['employee' => 'Tidak dapat membuat karyawan!']);
    }

    public function test_owner_can_update_employee_status()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();

        $employee = Employee::factory()->for($laundry)->create();

        $response = $this->putJson("/api/v1/owner/laundries/{$laundry->id}/employees/{$employee->id}", [
            'status' => 0
        ]);

        $response->assertOk()
            ->assertJsonPath('status', 0);
    }

    public function test_owner_cannot_update_employee_where_not_belongs_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();

        $employee = Employee::factory()->create();

        $response = $this->putJson("/api/v1/owner/laundries/{$laundry->id}/employees/{$employee->id}", [
            'status' => 0
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['employee' => 'Tidak dapat mengubah karyawan!']);
    }

    public function test_owner_cannot_update_employee_if_scope_not_provided()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner, []);

        $laundry = Laundry::factory()->for($owner)->create();

        $employee = Employee::factory()->for($laundry)->create();

        $response = $this->putJson("/api/v1/owner/laundries/{$laundry->id}/employees/{$employee->id}", [
            'status' => 0
        ]);

        $response->assertForbidden();
    }

    public function test_owner_can_delete_employee()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();

        $employee = Employee::factory()->for($laundry)->create();

        $response = $this->deleteJson("/api/v1/owner/laundries/{$laundry->id}/employees/{$employee->id}");

        $response->assertOk();

        $this->assertModelMissing($employee);
    }

    public function test_owner_cannot_delete_employee_if_not_belong_to_their_laundry()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner);

        $laundry = Laundry::factory()->for($owner)->create();

        $employee = Employee::factory()->create();

        $response = $this->deleteJson("/api/v1/owner/laundries/{$laundry->id}/employees/{$employee->id}");

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['employee' => 'Tidak dapat menghapus karyawan!']);

        $this->assertModelExists($employee);
    }

    public function test_owner_cannot_delete_employee_if_scope_not_provided()
    {
        $owner = User::factory()->create(['role' => User::ROLE_OWNER]);
        $this->actingAs($owner, []);

        $laundry = Laundry::factory()->for($owner)->create();

        $employee = Employee::factory()->for($laundry)->create();

        $response = $this->deleteJson("/api/v1/owner/laundries/{$laundry->id}/employees/{$employee->id}");

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['employee' => 'Tidak dapat menghapus karyawan!']);

        $this->assertModelExists($employee);
    }
}
