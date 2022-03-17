<?php namespace Tests\Repositories;

use App\Models\EpgCallback;
use App\Repositories\EpgCallbackRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EpgCallbackRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EpgCallbackRepository
     */
    protected $epgCallbackRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->epgCallbackRepo = \App::make(EpgCallbackRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_epg_callback()
    {
        $epgCallback = EpgCallback::factory()->make()->toArray();

        $createdEpgCallback = $this->epgCallbackRepo->create($epgCallback);

        $createdEpgCallback = $createdEpgCallback->toArray();
        $this->assertArrayHasKey('id', $createdEpgCallback);
        $this->assertNotNull($createdEpgCallback['id'], 'Created EpgCallback must have id specified');
        $this->assertNotNull(EpgCallback::find($createdEpgCallback['id']), 'EpgCallback with given id must be in DB');
        $this->assertModelData($epgCallback, $createdEpgCallback);
    }

    /**
     * @test read
     */
    public function test_read_epg_callback()
    {
        $epgCallback = EpgCallback::factory()->create();

        $dbEpgCallback = $this->epgCallbackRepo->find($epgCallback->id);

        $dbEpgCallback = $dbEpgCallback->toArray();
        $this->assertModelData($epgCallback->toArray(), $dbEpgCallback);
    }

    /**
     * @test update
     */
    public function test_update_epg_callback()
    {
        $epgCallback = EpgCallback::factory()->create();
        $fakeEpgCallback = EpgCallback::factory()->make()->toArray();

        $updatedEpgCallback = $this->epgCallbackRepo->update($fakeEpgCallback, $epgCallback->id);

        $this->assertModelData($fakeEpgCallback, $updatedEpgCallback->toArray());
        $dbEpgCallback = $this->epgCallbackRepo->find($epgCallback->id);
        $this->assertModelData($fakeEpgCallback, $dbEpgCallback->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_epg_callback()
    {
        $epgCallback = EpgCallback::factory()->create();

        $resp = $this->epgCallbackRepo->delete($epgCallback->id);

        $this->assertTrue($resp);
        $this->assertNull(EpgCallback::find($epgCallback->id), 'EpgCallback should not exist in DB');
    }
}
