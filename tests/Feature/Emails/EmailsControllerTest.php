<?php

namespace Tests\Feature\Emails;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

final class EmailsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index_unauth()
    {
        $response = $this->json('get', 'api/emails',
            [],
            []
         );

        $response->assertUnauthorized();
    }

    public function test_index_auth()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $token = $user->createToken('app-token')->plainTextToken;

        $response = $this->json('get', 'api/emails',
            [],
            ['Authorization' => "Bearer " . $token]
        );

        $response->assertOk();
    }
}
