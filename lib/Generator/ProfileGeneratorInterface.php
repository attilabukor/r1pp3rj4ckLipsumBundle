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

interface ProfileGeneratorInterface
{
    const SEX_RANDOM = 0;

    const SEX_MALE = 1;

    const SEX_FEMALE = 2;

    /**
     * Gets user data
     *
     * @param int $sex Chosen sex
     *
     * @return array
     */
    public function getUserData($sex = self::SEX_RANDOM);

    /**
     * Gets full name
     *
     * @param int  $sex        Chosen sex
     * @param bool $middleName Middle name needed
     *
     * @return string
     */
    public function getName($sex = self::SEX_RANDOM, $middleName = false);

    /**
     * Gets first name
     *
     * @param int $sex Chosen sex
     *
     * @return string
     */
    public function getFirstName($sex = self::SEX_RANDOM);

    /**
     * Gets last name
     *
     * @return string
     */
    public function getLastName();

    /**
     * Gets an email address specified by user name
     *
     * @param string $userName User name
     *
     * @return string
     */
    public function getEmail($userName);

    /**
     * Gets username by a full name
     *
     * @param string $name Full name
     *
     * @return string
     */
    public function getUsername($name);
}