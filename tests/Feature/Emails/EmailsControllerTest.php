<?php

namespace Tests\Feature\Emails;

use Tests\TestCase;
use App\Models\User;
use App\Models\Email;
use App\Jobs\MessageCreatedJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Foundation\Testing\DatabaseTransactions;


final class EmailsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @property $token
     */

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $token = $user->createToken('app-token')->plainTextToken;

        $this->token = $token;
    }

    public function test_index_unAuth()
    {
        $response = $this->json('get', 'api/emails',
            [],
            []
         );

        $response->assertUnauthorized();
    }

    public function test_index_auth()
    {
        $response = $this->json('get', 'api/emails',
            [],
            ['Authorization' => "Bearer " . $this->token]
        );

        $response->assertOk();
    }

    public function test_store()
    {
        $response = $this->json('post', 'api/emails',
            [
                'email' => 'test@test.com'
            ],
            ['Authorization' => "Bearer " . $this->token]
        );

        $response->assertJsonFragment([
            'isSuccess' => true,
            'email' => [
                'value' => 'test@test.com',
                'name' => 'test',
                'domain' => 'test.com'
            ]
        ]);
    }

    public function test_update()
    {
        Bus::fake();

        $email = Email::factory()->create();

        $response = $this->json('put', 'api/emails/' . $email->id,
            [],
            ['Authorization' => "Bearer " . $this->token]
        );

        //created message
        $this->assertDatabaseHas('messages', [
            'email_id' => $email->id
        ]);

        Bus::assertDispatched(MessageCreatedJob::class);
    }
}
