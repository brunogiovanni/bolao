<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RodadasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RodadasTable Test Case
 */
class RodadasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RodadasTable
     */
    public $Rodadas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Rodadas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Rodadas') ? [] : ['className' => RodadasTable::class];
        $this->Rodadas = TableRegistry::getTableLocator()->get('Rodadas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Rodadas);

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
}
