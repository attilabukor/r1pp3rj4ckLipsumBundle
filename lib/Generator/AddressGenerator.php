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

use Symfony\Component\HttpFoundation\File\File;

/**
 * Address generator
 *
 * @auhor r1pp3rj4ck <attila.bukor@gmail.com>
 */
class AddressGenerator
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
        $file = new File($streetNames);
        $splFileObject = $file->openFile('r');
        while (!$splFileObject->eof()) {
            $this->streetNames[] = $splFileObject->fgets();
        }
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
        return $this->streetNames[mt_rand(0, count($this->streetNames) - 1)] . ' ' . mt_rand(1000,9999);
    }
}
