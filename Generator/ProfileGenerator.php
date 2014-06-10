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
 * Generates random data
 *
 * @author r1pp3rj4ck <attila.bukor@gmail.com>
 */
class ProfileGenerator implements ProfileGeneratorInterface
{
    /**
     * @var string $maleNames Male names source file
     */
    private $maleNames;

    /**
     * @var string $femaleNames Female names source file
     */
    private $femaleNames;

    /**
     * @var string $lastNames Last names source file
     */
    private $lastNames;

    /**
     * Constructor
     *
     * @param string $maleNames   Male names source file
     * @param string $femaleNames Female names source file
     * @param string $lastNames   Last names source file
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function __construct($maleNames, $femaleNames, $lastNames)
    {
        $this->populateNames($maleNames, $this->maleNames);
        $this->populateNames($femaleNames, $this->femaleNames);
        $this->populateNames($lastNames, $this->lastNames);
    }

    /**
     * Gets user data in an array
     *
     * Contains name, user name and email. Sex can be specified:
     * Generator::SEX_RANDOM - random sex
     * Generator::SEX_MALE - male name
     * Generator::SEX_FEMALE - female name
     *
     * @param int $sex Chosen sex
     *
     * @return array
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function getUserData($sex = self::SEX_RANDOM)
    {
        $name                 = $this->getName($sex, rand(1,100) > 90);
        $result['fullName']   = $name['fullName'];
        $result['firstName']  = $name['firstName'];
        $result['middleName'] = $name['middleName'];
        $result['lastName']   = $name['lastName'];
        $result['userName']   = $this->getUserName($result['fullName']);
        $result['email']      = $this->getEmail($result['userName']);

        return $result;
    }

    /**
     * Gets a full name
     *
     * Creates a random name, sex can be specified:
     * Generator::SEX_RANDOM - random sex
     * Generator::SEX_MALE - male name
     * Generator::SEX_FEMALE - female name
     *
     * @param int  $sex        Chosen sex
     * @param bool $middleName Middle name needed
     *
     * @return string[]
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function getName($sex = self::SEX_RANDOM, $middleName = false)
    {
        $name['firstName'] = $this->getFirstName($sex);
        $name['lastName']  = $this->getLastName();
        if ($middleName) {
            $name['middleName'] = $name['firstName'];
            while (($name['middleName'] = $this->getFirstName($sex)) == $name['firstName']);
            $name['fullName'] = implode(' ', array($name['firstName'], $name['middleName'], $name['lastName']));
            return $name;
        } else {
            $name['fullName'] = implode(' ', array($name['firstName'], $name['lastName']));
            $name['middleName'] = '';
            return $name;
        }
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
    public function getEmail($userName)
    {
        $emailProviders = array(
            'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'facebook.com',
        );

        return $userName . '@' . $emailProviders[rand(0, count($emailProviders) -1)];
    }

    /**
     * Gets a user name by a full name
     *
     * Concatenates the names by a period and appends a
     * random number from 0 to 1000.
     *
     * @param string $name Full name
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function getUserName($name)
    {
        return strtolower(str_replace(' ', '.', $name)) . (string)rand(1, 1000);
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
    public function getFirstName($sex = self::SEX_RANDOM)
    {
        switch ($sex) {
            case self::SEX_FEMALE:
                return $this->getFemaleName();
            case self::SEX_MALE:
                return $this->getMaleName();
            default:
                return rand(1, 2) == 1
                    ? $this->getMaleName()
                    : $this->getFemaleName();
        }
    }

    /**
     * Gets a random last name.
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function getLastName()
    {
        return $this->lastNames[rand(0, count($this->lastNames) -1)];
    }

    /**
     * Gets a random female first name
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    protected function getFemaleName()
    {
        return $this->femaleNames[rand(0, count($this->femaleNames) -1)];
    }

    /**
     * Gets a random male first name
     *
     * @return string
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    protected function getMaleName()
    {
        return $this->maleNames[rand(0, count($this->maleNames) -1)];
    }

    /**
     * Populate names from file to an array
     *
     * @param string $filename File name containing the names
     * @param array  $array    Target array reference
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    private function populateNames($filename, &$array)
    {
        $handle = fopen($filename, 'r');
        while (($name = fgets($handle)) !== false) {
            $array[] = trim(ucfirst(strtolower($name)));
        }

        fclose($handle);
    }
}
