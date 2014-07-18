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

use r1pp3rj4ck\LipsumBundle\Model\Profile;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Generates random data
 *
 * @author r1pp3rj4ck <attila.bukor@gmail.com>
 */
class ProfileGenerator
{
    const SEX_RANDOM = 0;

    const SEX_MALE = 1;

    const SEX_FEMALE = 2;

    /**
     * @var array $maleNames Male names array
     */
    private $maleNames = array();

    /**
     * @var array $femaleNames Female names array
     */
    private $femaleNames = array();

    /**
     * @var array $lastNames Last names array
     */
    private $lastNames = array();

    private $emailProviders = array();

    private $addressGenerator;

    /**
     * Constructor
     *
     * @param string $maleNames Male names source file
     * @param string $femaleNames Female names source file
     * @param string $lastNames Last names source file
     * @param array $emailProviders Email providers
     * @param AddressGenerator $addressGenerator Address generator
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function __construct(
        $maleNames,
        $femaleNames,
        $lastNames,
        array $emailProviders,
        AddressGenerator $addressGenerator
    ) {
        $this->maleNames = $this->populateNames($maleNames);
        $this->femaleNames = $this->populateNames($femaleNames);
        $this->lastNames = $this->populateNames($lastNames);
        $this->emailProviders = $emailProviders;
        $this->addressGenerator = $addressGenerator;
    }

    /**
     * Populate names from file to an array
     *
     * @param string $filename File name containing the names
     *
     * @return array
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    private function populateNames($filename)
    {
        $names = array();
        $file = new File($filename);
        $splFileObject = $file->openFile('r');
        while (!$splFileObject->eof()) {
            $names[] = trim($splFileObject->fgets());
        }
        return $names;
    }

    /**
     * @param int $sex
     * @param null $middleName
     *
     * @return Profile
     */
    public function createUser($sex = self::SEX_RANDOM, $middleName = null)
    {
        if ($sex === self::SEX_RANDOM && mt_rand(0, 1) || $sex === self::SEX_MALE) {
            $sex = self::SEX_MALE;
        } else {
            $sex = self::SEX_FEMALE;
        }

        $profile = new Profile();
        $firstName = $this->getFirstName($sex);
        $lastName = $this->getLastName();
        $profile
            ->setFirstName($firstName)
            ->setLastName($lastName);

        if ($middleName === null && mt_rand(0, 2) == 1 || $middleName === true) {
            while (($middleName = $this->getFirstName($sex)) == $firstName) {
                ;
            }
            $profile->setMiddleName($middleName);
        }

        $userName = $this->getUserName($firstName, $lastName);
        $profile
            ->setUserName($userName)
            ->setAddress($this->addressGenerator->getAddress())
            ->setEmail($this->getEmail(mt_rand(0, 2) ? $userName : $this->getUserName($firstName, $lastName)));

        return $profile;
    }

    /**
     * Gets a first name
     *
     * Sex can be specified:
     * Generator::SEX_RANDOM - random sex
     * Generator::SEX_MALE - male name
     * Generator::SEX_FEMALE - female name
     *
     * @param int $sex Chosen sex
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    protected function getFirstName($sex)
    {
        if ($sex === self::SEX_MALE) {
            return $this->maleNames[mt_rand(0, count($this->maleNames) - 1)];
        } else {
            return $this->femaleNames[mt_rand(0, count($this->femaleNames) - 1)];
        }
    }

    /**
     * Gets a random last name.
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    protected function getLastName()
    {
        return $this->lastNames[mt_rand(0, count($this->lastNames) - 1)];
    }

    /**
     * Gets a user name by a full name
     *
     * @param string $firstName First name
     * @param string $lastName Last name
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    protected function getUserName($firstName, $lastName)
    {
        $firstName = mt_rand(0, 10) % 3 == 0 ? $firstName : strtolower($firstName);
        $lastName = mt_rand(0, 10) % 3 == 0 ? $lastName : strtolower($lastName);
        $separators = ['_', '-', '.', ''];
        $firstName = mt_rand(0, 10) % 4 == 0 ? $firstName : substr($firstName, 0, 1);
        $separator = $separators[mt_rand(
            0,
            count($separators) - 1
        )];
        $number = mt_rand(1, 10) % 4 == 0 ? mt_rand(1, 100) : '';
        return $firstName . $separator . $lastName . $number;
    }

    /**
     * Gets an email by a user name
     *
     * Appends an email provider to the user name.
     *
     * @param string $userName Chosen user name
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    protected function getEmail($userName)
    {
        return $userName . '@' . $this->emailProviders[mt_rand(0, count($this->emailProviders) - 1)];
    }
}
