<?php

namespace App\Tests\Service;

use App\Service\TestEmailService;
use PHPUnit\Framework\TestCase;

class TestEmailTest extends TestCase
{
    public function testValidEmail()
    {

        $testEMail = new TestEmailService();

        $result = $testEMail->testEmail('nom@domaine.com');

        $this->assertEquals(1, $result);
    }

    public function testEmptyEmail()
    {

        $testEMail = new TestEmailService();

        $result = $testEMail->testEmail('');

        $this->assertEquals(1, $result);
    }

    public function testNoArobaseEmail()
    {

        $testEMail = new TestEmailService();

        $result = $testEMail->testEmail('nomdomaine.com');

        $this->assertEquals(1, $result);
    }

    public function testNoDotEmail()
    {

        $testEMail = new TestEmailService();

        $result = $testEMail->testEmail('nom@domainecom');

        $this->assertEquals(1, $result);
    }

    public function testNoArobaseNoDotEmail()
    {
        $testEMail = new TestEmailService();

        $result = $testEMail->testEmail('nomdomainecom');

        $this->assertEquals(1, $result);
    }

    public function testSpecialCharEmail()
    {
        $testEMail = new TestEmailService();

        $result = $testEMail->testEmail('nom@&*domainecom');

        $this->assertEquals(1, $result);
    }
}