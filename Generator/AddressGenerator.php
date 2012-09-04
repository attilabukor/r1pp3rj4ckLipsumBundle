<?php

/*
 * This file is part of the LipsumBundle package.
 *
 * (c) Attila Bukor <attila.bukor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace r1pp3rj4ck\LipsumBundle\Generator;

/**
 * Address generator
 *
 * @auhor r1pp3rj4ck <attila.bukor@gmail.com>
 */
class AddressGenerator implements AddressGeneratorInterface
{
    /**
     * @var array $streetNames
     */
    private $streetNames;

    /**
     * Constructor
     *
     * @param string $streetNames Path of the file containing the street names
     */
    public function __construct($streetNames)
    {
        $handle = fopen($streetNames, 'r');

        while (($streetName = fgets($handle)) !== false) {
            $this->streetNames[] = trim($streetName);
        }

        fclose($handle);
    }

    /**
     * Gets a street name
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function getStreetName()
    {
        return $this->streetNames[rand(0, count($this->streetNames) -1)];
    }

    /**
     * Gets an address
     *
     * @return array
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function getAddress()
    {
        $address['streetName'] = $this->getStreetName();
        $address['streetNumber'] = rand(1, 999);
        $address['fullAddress'] = $address['streetName'] . ' ' . $address['streetNumber'];
        return $address;
    }
}