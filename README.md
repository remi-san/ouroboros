Ouroboros
=========

    "εν το παν"

`Ouroboros` is a simple library letting you creating end to end (e2e) tests
with your favorite PHP test framework. Like the snake eating its own tail
it's inspired from, *Ouroboros* lib will let you easily create, destroy the
app to test and do it all over again for each test.
 
How to use it?
--------------

Initialize your `TestHelper`
```php
$this->testHelper = new TestHelper(
    new MakefileInfrastructureHelper($appBasePath), // or any other infra helper
    new CommandLauncherApplicationHelper($appBasePath, 'make run'), // or any other app helper
    new LoggerConditionWaiter( // if you want to follow a logfile for completion condition
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
```

Use it in your test file (here with `phpunit`)
```php
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
}

/**
 * @test
 */
public function itShouldWaitForAllConditionsAndSucceed()
{
    $this->testHelper->wait([self::CONDITION_ONE, self::CONDITION_TWO]);
}
```
