<?php namespace Tests\Repositories;

use App\Models\CollectOnBehalf;
use App\Repositories\CollectOnBehalfRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CollectOnBehalfRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CollectOnBehalfRepository
     */
    protected $collectOnBehalfRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->collectOnBehalfRepo = \App::make(CollectOnBehalfRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_collect_on_behalf()
    {
        $collectOnBehalf = CollectOnBehalf::factory()->make()->toArray();

        $createdCollectOnBehalf = $this->collectOnBehalfRepo->create($collectOnBehalf);

        $createdCollectOnBehalf = $createdCollectOnBehalf->toArray();
        $this->assertArrayHasKey('id', $createdCollectOnBehalf);
        $this->assertNotNull($createdCollectOnBehalf['id'], 'Created CollectOnBehalf must have id specified');
        $this->assertNotNull(CollectOnBehalf::find($createdCollectOnBehalf['id']), 'CollectOnBehalf with given id must be in DB');
        $this->assertModelData($collectOnBehalf, $createdCollectOnBehalf);
    }

    /**
     * @test read
     */
    public function test_read_collect_on_behalf()
    {
        $collectOnBehalf = CollectOnBehalf::factory()->create();

        $dbCollectOnBehalf = $this->collectOnBehalfRepo->find($collectOnBehalf->id);

        $dbCollectOnBehalf = $dbCollectOnBehalf->toArray();
        $this->assertModelData($collectOnBehalf->toArray(), $dbCollectOnBehalf);
    }

    /**
     * @test update
     */
    public function test_update_collect_on_behalf()
    {
        $collectOnBehalf = CollectOnBehalf::factory()->create();
        $fakeCollectOnBehalf = CollectOnBehalf::factory()->make()->toArray();

        $updatedCollectOnBehalf = $this->collectOnBehalfRepo->update($fakeCollectOnBehalf, $collectOnBehalf->id);

        $this->assertModelData($fakeCollectOnBehalf, $updatedCollectOnBehalf->toArray());
        $dbCollectOnBehalf = $this->collectOnBehalfRepo->find($collectOnBehalf->id);
        $this->assertModelData($fakeCollectOnBehalf, $dbCollectOnBehalf->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_collect_on_behalf()
    {
        $collectOnBehalf = CollectOnBehalf::factory()->create();

        $resp = $this->collectOnBehalfRepo->delete($collectOnBehalf->id);

        $this->assertTrue($resp);
        $this->assertNull(CollectOnBehalf::find($collectOnBehalf->id), 'CollectOnBehalf should not exist in DB');
    }
}
