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
use r1pp3rj4ck\LipsumBundle\Generator\AddressGenerator;

class AddressGeneratorTest extends WebTestCase
{
    private $addressGenerator;

    public function setUp()
    {
        $this->addressGenerator = new AddressGenerator('data/streetnames.txt');
    }

    public function testGetStreetName()
    {
        $streetName = $this->addressGenerator->getStreetName();

        $this->assertNotEquals($streetName, '');
    }

    public function testGetAddress()
    {
        $address = $this->addressGenerator->getAddress();

        $this->assertArrayHasKey('fullAddress', $address);
        $this->assertArrayHasKey('streetName', $address);
        $this->assertArrayHasKey('streetNumber', $address);
        $this->assertEquals(3, count($address));
        $this->assertRegExp('/^[a-zA-Z0-9 ]+$/', $address['streetName']);
        $this->assertEquals((int) $address['streetNumber'], $address['streetNumber']);
        $this->assertRegExp('/^[a-zA-Z0-9 ]+[0-9]+$/', $address['fullAddress']);
    }

}
