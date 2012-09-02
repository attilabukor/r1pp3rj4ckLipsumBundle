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

use r1pp3rj4ck\LipsumBundle\Generator\Generator;

class GeneratorTest extends WebTestCase
{
    private $generator;

    public function setUp()
    {
        $this->generator = new Generator('data/malenames.txt', 'data/femalenames.txt', 'data/lastnames.txt');
    }

    public function testGetUserData()
    {
        $userData = $this->generator->getUserData();
        $this->assertNotEquals(null, $userData);
        $this->assertNotEquals(array(), $userData);
    }

    public function testGetName()
    {
        $name = $this->generator->getName();
        $nameCount = count(explode(' ', $name));

        $this->assertGreaterThanOrEqual(2, $nameCount);
        $this->assertLessThanOrEqual(3, $nameCount);
    }

    public function testGetUserName()
    {
        $name = $this->generator->getName();
        $username = $this->generator->getUserName($name);

        switch(count(explode(' ', $name))) {
            case 2:
                $this->assertRegExp('/^[a-z]+\.[a-z]+[0-9]+$/', $username);
                break;
            case 3:
                $this->assertRegExp('/^[a-z]+\.[a-z]+\.[a-z]+[0-9]+$/', $username);
                break;
        }
    }

    public function testGetEmail()
    {
        $name = $this->generator->getName();
        $username = $this->generator->getUserName($name);
        $email = $this->generator->getEmail($username);

        switch (count(explode(' ', $name))) {
            case 2:
                $this->assertRegExp('/^[a-z]+\.[a-z]+[0-9]+\@.*\..*$/', $email);
                break;
            case 3:
                $this->assertRegExp('/^[a-z]+\.[a-z]+\/[a-z]+[0-9]+\@.*\..*$/', $email);
                break;
        }

        $this->assertEquals($username, strstr($email, '@', true));
    }
}