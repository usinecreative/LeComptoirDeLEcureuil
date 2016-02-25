<?php

namespace JK\StaticClientBundle\Tests\StaticClientBundle\Client;

use Closure;
use Exception;
use JK\StaticClientBundle\Client\StaticClient;
use PHPUnit_Framework_TestCase;
use SplFileInfo;

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testPost()
    {
        $client = new StaticClient('http://localhost:8000/');


        // if the file does not exists, it SHOULD thrown an exception
        $this->assertExceptionRaised('Exception', function() use ($client) {
            $client->post(new SplFileInfo('/tmp/test.txt'));
        });
    }

    /**
     * Assert that an exception is raised in the given code.
     *
     * @param $exceptionClass
     * @param Closure $closure
     */
    protected function assertExceptionRaised($exceptionClass, Closure $closure)
    {
        $e = null;
        $isClassValid = false;

        try {
            $closure();
        } catch (Exception $e) {
            if (get_class($e) == $exceptionClass) {
                $isClassValid = true;
            }
        }
        $this->assertTrue($isClassValid, 'Expected ' . $exceptionClass . ', got ' . get_class($e));
    }
}
