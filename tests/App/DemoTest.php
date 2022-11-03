<?php

namespace Test\App;

use PHPUnit\Framework\TestCase;

use App\Service\AppLogger;
use App\Util\HttpRequest;
use App\App\Demo;

class DemoTest extends TestCase
{

   /* public function test_foo()
    {
    }
*/
    public function test_get_user_info()
    {
        $demoUserInfo = [
            'id'       => 1,
            'username' => 'hello world',
        ];

        $demo     = new Demo(new AppLogger('think-log'), new HttpRequest);
        $userInfo = $demo->get_user_info();

        $this->assertJsonStringEqualsJsonString(json_encode($demoUserInfo), json_encode($userInfo));
    }
}
