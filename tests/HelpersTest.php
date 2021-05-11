<?php

require_once __DIR__ . '/../src/Helpers/helpers.php';
require_once __DIR__ . '/../config/settings.php';

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function setUp() : void
    {
        
    }

    public function tearDown() : void
    {

    }

    public function test_onlynumbers_function_returns_correct_value()
    {
        $input = 'abc123';
        $output = only_numbers($input);

        $this->assertEquals('123', $output);
    }

    /**
     * @dataProvider messagesProvider
     */
    public function test_openssl_cryptographs_correctly()
    {
        $message = 'is consequuntur aperiam nam, voluptatum harum optio id suscipit laboriosam quo quam quod ut, dolor ducimus incidunt veniam ullam?';
        $encrypted = encrypt($message);
        $decrypted = decrypt($encrypted);

        $this->assertEquals($message, $decrypted);
    }

    /**
     * @dataProvider messagesProvider
     */
    public function test_sodium_cryptographs_correctly($message)
    {
        $encrypted = encrypt($message, 'Sodium');
        $decrypted = decrypt($encrypted, 'Sodium');

        $this->assertEquals($message, $decrypted);
    }

    public function messagesProvider()
    {
        return [
            'Regular message' => ['John Doe works in that company right around the corner!'],
            'Weird message' => ['Lor45*em ipsum do%lor sit a!m#ADVet consec41tetur*(, adi!@#pisicing elit. Minus quis illo om¨n&'],
        ];
    }
}
