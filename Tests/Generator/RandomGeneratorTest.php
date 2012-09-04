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

use r1pp3rj4ck\LipsumBundle\Generator\RandomGenerator;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RandomGeneratorTest extends WebTestCase
{

    private $randomGenerator;

    public function setUp()
    {
        $this->randomGenerator = new RandomGenerator('data/lipsum.txt');
    }

    public function testGetRandomWithPunctuation()
    {
        $wordCount = rand(1, 1000);

        $random = $this->randomGenerator->getRandom($wordCount);

        preg_match_all('/[a-zA-Z]+/', $random, $words);

        $this->assertEquals($wordCount, count($words[0]));
        $this->assertRegExp('/^.*\.$/', $random);
    }

    public function testGetRandomWithoutPunctuation()
    {
        $wordCount = rand(1, 1000);

        $random = $this->randomGenerator->getRandom($wordCount, RandomGenerator::PUNCTUATION_NONE);

        preg_match_all('/[a-zA-Z]+/', $random, $words);

        $this->assertEquals($wordCount, count($words[0]));
        $this->assertRegExp('/^.*[^\.]$/', $random);
    }
}