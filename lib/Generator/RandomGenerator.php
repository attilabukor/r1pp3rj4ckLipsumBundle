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
 * Random generator
 *
 * @author r1pp3rj4ck <attila.bukor@gmail.com>
 */
class RandomGenerator implements RandomGeneratorInterface
{
    /**
     * @var array $randomStrings
     */
    private $randomStrings;

    /**
     * Constructor
     *
     * @param string $randomFile Random file name
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function __construct($randomFile)
    {
        $handle = fopen($randomFile, 'r');
        while (($line = fgets($handle)) !== false) {
            preg_match_all('/[a-zA-Z]+/', $line, $strings);
            foreach ($strings[0] as $string) {
                $this->randomStrings[] = strtolower($string);
            }
        }

        fclose($handle);
        $this->randomStrings = array_values(array_unique($this->randomStrings));
    }

    /**
     * {@inheritDoc}
     *
     * @author r1pp3rj4ck <attila.bukor@gmail.com>
     */
    public function getRandom($wordCount = 42, $punctuation = self::PUNCTUATION_ON)
    {
        $words = array();
        $capNext = true;
        for ($i = 0; $i < $wordCount; $i++) {
            $word = $this->randomStrings[rand(0, count($this->randomStrings) - 1)];
            $word = $capNext
                ? ucfirst($word)
                : $word;

            $capNext = false;

            if ($i == $wordCount - 1 && ($punctuation == self::PUNCTUATION_AT_END || $punctuation == self::PUNCTUATION_ON)) {
                $word .= '.';
            } elseif ($punctuation == self::PUNCTUATION_ON && rand(0, 100) > 80) {
                $word .= ',';
            } elseif ($punctuation == self::PUNCTUATION_ON && rand(0, 100) > 90) {
                $word .= '.';
                $capNext = true;
            }

            $words[] = $word;
        }

        return implode(' ', $words);
    }
}
