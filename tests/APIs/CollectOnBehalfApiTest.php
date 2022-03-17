<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CollectOnBehalf;

class CollectOnBehalfApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_collect_on_behalf()
    {
        $collectOnBehalf = CollectOnBehalf::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/collect_on_behalves', $collectOnBehalf
        );

        $this->assertApiResponse($collectOnBehalf);
    }

    /**
     * @test
     */
    public function test_read_collect_on_behalf()
    {
        $collectOnBehalf = CollectOnBehalf::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/collect_on_behalves/'.$collectOnBehalf->id
        );

        $this->assertApiResponse($collectOnBehalf->toArray());
    }

    /**
     * @test
     */
    public function test_update_collect_on_behalf()
    {
        $collectOnBehalf = CollectOnBehalf::factory()->create();
        $editedCollectOnBehalf = CollectOnBehalf::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/collect_on_behalves/'.$collectOnBehalf->id,
            $editedCollectOnBehalf
        );

        $this->assertApiResponse($editedCollectOnBehalf);
    }

    /**
     * @test
     */
    public function test_delete_collect_on_behalf()
    {
        $collectOnBehalf = CollectOnBehalf::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/collect_on_behalves/'.$collectOnBehalf->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/collect_on_behalves/'.$collectOnBehalf->id
        );

        $this->response->assertStatus(404);
    }
}
