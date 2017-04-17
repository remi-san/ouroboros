<?php

namespace RemiSan\Ouroboros\Tests\Integration;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use RemiSan\Ouroboros\Application\CommandLauncherApplicationHelper;
use RemiSan\Ouroboros\Infrastructure\MakefileInfrastructureHelper;
use RemiSan\Ouroboros\Matcher\Factory\TextConditionMatcherFactory;
use RemiSan\Ouroboros\TestHelper;
use RemiSan\Ouroboros\Waiter\LoggerConditionWaiter;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    const CONDITION_ONE = 'condition_1';
    const CONDITION_TWO = 'condition_2';

    /** @var TestHelper */
    private $testHelper;

    /**
     * IntegrationTest constructor.
     *
     * @param string $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $appBasePath = dirname(dirname(__DIR__)) . '/app';
        $logFile = $appBasePath . '/log/app.log';
        $logger = new Logger('TEST');
        $logger->pushHandler(new StreamHandler('file://' . $logFile, Logger::DEBUG));

        $this->testHelper = new TestHelper(
            new MakefileInfrastructureHelper($appBasePath),
            new CommandLauncherApplicationHelper($appBasePath, 'make run'),
            new LoggerConditionWaiter(
                $logFile,
                new TextConditionMatcherFactory(
                    [
                        self::CONDITION_ONE => 'This is my first condition',
                        self::CONDITION_TWO => 'This is my second condition',
                    ]
                ),
                $logger,
                5
            )
        );
    }

    /**
     * Init.
     */
    public function setUp()
    {
        $this->testHelper->setUp();
    }

    /**
     * Close.
     */
    public function tearDown()
    {
        $this->testHelper->tearDown();

        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldWaitForAllConditionsAndSucceed()
    {
        $this->testHelper->wait([self::CONDITION_ONE, self::CONDITION_TWO]);
    }
}
