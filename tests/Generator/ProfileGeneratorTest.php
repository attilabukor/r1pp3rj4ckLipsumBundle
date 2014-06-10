<?php

/*
 * This file is part of the LipsumBundle package.
 *
 * (c) Attila Bukor <attila.bukor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace r1pp3rj4ck\LipsumBundle\Tests\Generator;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use r1pp3rj4ck\LipsumBundle\Generator\ProfileGenerator;

class ProfileGeneratorTest extends WebTestCase
{
    private $profileGenerator;

    public function setUp()
    {
        $this->profileGenerator = new ProfileGenerator('data/malenames.txt', 'data/femalenames.txt', 'data/lastnames.txt');
    }

    public function testGetUserData()
    {
        $userData = $this->profileGenerator->getUserData();
        $this->assertNotEquals(null, $userData);
        $this->assertNotEquals(array(), $userData);
    }

    public function testGetTwoPartName()
    {
        $name = $this->profileGenerator->getName(ProfileGenerator::SEX_RANDOM, false);

        $this->assertArrayHasKey('fullName', $name);
        $this->assertArrayHasKey('firstName', $name);
        $this->assertArrayHasKey('middleName', $name);
        $this->assertArrayHasKey('lastName', $name);
        $this->assertNotEmpty($name['fullName']);
        $this->assertNotEmpty($name['firstName']);
        $this->assertEmpty($name['middleName']);
        $this->assertNotEmpty($name['lastName']);
        $this->assertEquals(count($name), 4);
    }

    public function testGetThreePartName()
    {
        $name = $this->profileGenerator->getName(ProfileGenerator::SEX_RANDOM, true);

        $this->assertArrayHasKey('fullName', $name);
        $this->assertArrayHasKey('firstName', $name);
        $this->assertArrayHasKey('middleName', $name);
        $this->assertArrayHasKey('lastName', $name);
        $this->assertNotEmpty($name['fullName']);
        $this->assertNotEmpty($name['firstName']);
        $this->assertNotEmpty($name['middleName']);
        $this->assertNotEmpty($name['lastName']);
        $this->assertEquals(count($name), 4);
    }

    public function testGetUserName()
    {
        $name = $this->profileGenerator->getName();
        $username = $this->profileGenerator->getUserName($name['fullName']);

        $this->assertRegExp('/^[a-z]+\.[a-z]+[0-9]+$/', $username);
    }

    public function testGetEmail()
    {
        $name = $this->profileGenerator->getName();
        $username = $this->profileGenerator->getUserName($name['fullName']);
        $email = $this->profileGenerator->getEmail($username);

        $this->assertRegExp('/^[a-z]+\.[a-z]+[0-9]+\@.*\..*$/', $email);

        $this->assertEquals($username, strstr($email, '@', true));
    }

    public function testGetFirstName()
    {
        $name = $this->profileGenerator->getFirstName();
        $this->assertNotEmpty($name);
        $female = $this->profileGenerator->getFirstName(ProfileGenerator::SEX_FEMALE);
        $this->assertNotEmpty($female);
        $male = $this->profileGenerator->getFirstName(ProfileGenerator::SEX_MALE);
        $this->assertNotEmpty($male);
        $this->assertNotEquals($male, $female);

        $rc = new \ReflectionClass('\r1pp3rj4ck\LipsumBundle\Generator\ProfileGenerator');
        $maleNamesProperty = $rc->getProperty('maleNames');
        $maleNamesProperty->setAccessible(true);
        $maleNames = $maleNamesProperty->getValue($this->profileGenerator);

        $this->assertContains($male, $maleNames);

        $femaleNamesProperty = $rc->getProperty('femaleNames');
        $femaleNamesProperty->setAccessible(true);
        $femaleNames = $femaleNamesProperty->getValue($this->profileGenerator);

        $this->assertContains($female, $femaleNames);
    }
}
