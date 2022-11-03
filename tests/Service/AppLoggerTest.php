<?php

namespace Test\Service;

use PHPUnit\Framework\TestCase;
use App\Service\AppLogger;

/**
 * Class ProductHandlerTest
 */
class AppLoggerTest extends TestCase
{

    public function testInfoLog()
    {
        $logger = new AppLogger('think-log');
        $logger->info('This is info log message');
        var_dump($logger);exit;
    }
}