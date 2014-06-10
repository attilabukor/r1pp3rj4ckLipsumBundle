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

interface AddressGeneratorInterface
{
    /**
     * Gets street name
     *
     * @return string
     */
    public function getStreetName();

    /**
     * Gets address
     *
     * @return array
     */
    public function getAddress();
}
