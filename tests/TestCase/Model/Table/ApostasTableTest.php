<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApostasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApostasTable Test Case
 */
class ApostasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ApostasTable
     */
    public $Apostas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Apostas',
        'app.Users',
        'app.Jogos',
        'app.Equipes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Apostas') ? [] : ['className' => ApostasTable::class];
        $this->Apostas = TableRegistry::getTableLocator()->get('Apostas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Apostas);

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
