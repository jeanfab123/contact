<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\TestEmailService;

class TestEmailTest extends TestCase
{
    public function testValidEmail()
    {

        $testEmail = new TestEmailService();

        $result = $testEmail->test('nom@domaine.com');

        $this->assertEquals(1, $result);
    }

    public function testEmptyEmail()
    {

        $testEmail = new TestEmailService();

        $result = $testEmail->test('');

        $this->assertEquals(1, $result);
    }

    public function testNoArobaseEmail()
    {

        $testEmail = new TestEmailService();

        $result = $testEmail->test('nomdomaine.com');

        $this->assertEquals(1, $result);
    }

    public function testNoDotEmail()
    {

        $testEmail = new TestEmailService();

        $result = $testEmail->test('nom@domainecom');

        $this->assertEquals(1, $result);
    }

    public function testNoArobaseNoDotEmail()
    {
        $testEmail = new TestEmailService();

        $result = $testEmail->test('nomdomainecom');

        $this->assertEquals(1, $result);
    }

    public function testSpecialCharEmail()
    {
        $testEmail = new TestEmailService();

        $result = $testEmail->test('nom@&*domainecom');

        $this->assertEquals(1, $result);
    }
}