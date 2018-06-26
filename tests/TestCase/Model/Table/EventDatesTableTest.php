<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventDatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventDatesTable Test Case
 */
class EventDatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EventDatesTable
     */
    public $EventDates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.event_dates',
        'app.events',
        'app.event_date_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EventDates') ? [] : ['className' => EventDatesTable::class];
        $this->EventDates = TableRegistry::getTableLocator()->get('EventDates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EventDates);

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
