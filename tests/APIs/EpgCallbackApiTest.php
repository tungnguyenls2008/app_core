<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\EpgCallback;

class EpgCallbackApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_epg_callback()
    {
        $epgCallback = EpgCallback::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/epg_callbacks', $epgCallback
        );

        $this->assertApiResponse($epgCallback);
    }

    /**
     * @test
     */
    public function test_read_epg_callback()
    {
        $epgCallback = EpgCallback::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/epg_callbacks/'.$epgCallback->id
        );

        $this->assertApiResponse($epgCallback->toArray());
    }

    /**
     * @test
     */
    public function test_update_epg_callback()
    {
        $epgCallback = EpgCallback::factory()->create();
        $editedEpgCallback = EpgCallback::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/epg_callbacks/'.$epgCallback->id,
            $editedEpgCallback
        );

        $this->assertApiResponse($editedEpgCallback);
    }

    /**
     * @test
     */
    public function test_delete_epg_callback()
    {
        $epgCallback = EpgCallback::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/epg_callbacks/'.$epgCallback->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/epg_callbacks/'.$epgCallback->id
        );

        $this->response->assertStatus(404);
    }
}
