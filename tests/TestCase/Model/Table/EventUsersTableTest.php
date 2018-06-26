<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventUsersTable Test Case
 */
class EventUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EventUsersTable
     */
    public $EventUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.event_users',
        'app.users',
        'app.events'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EventUsers') ? [] : ['className' => EventUsersTable::class];
        $this->EventUsers = TableRegistry::getTableLocator()->get('EventUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EventUsers);

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
