<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlacarFinalTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlacarFinalTable Test Case
 */
class PlacarFinalTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PlacarFinalTable
     */
    public $PlacarFinal;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PlacarFinal',
        'app.Jogos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PlacarFinal') ? [] : ['className' => PlacarFinalTable::class];
        $this->PlacarFinal = TableRegistry::getTableLocator()->get('PlacarFinal', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PlacarFinal);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
