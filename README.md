r1pp3rj4ckLipsumBundle
======================

Generates bullshit for fixtures and other uses

[![Build Status](https://secure.travis-ci.org/r1pp3rj4ck/r1pp3rj4ckLipsumBundle.png?branch=master)](http://travis-ci.org/r1pp3rj4ck/r1pp3rj4ckLipsumBundle) [![Latest Stable Version](https://poser.pugx.org/r1pp3rj4ck/lipsum-bundle/v/stable.svg)](https://packagist.org/packages/r1pp3rj4ck/lipsum-bundle) [![Total Downloads](https://poser.pugx.org/r1pp3rj4ck/lipsum-bundle/downloads.svg)](https://packagist.org/packages/r1pp3rj4ck/lipsum-bundle) [![Latest Unstable Version](https://poser.pugx.org/r1pp3rj4ck/lipsum-bundle/v/unstable.svg)](https://packagist.org/packages/r1pp3rj4ck/lipsum-bundle) [![License](https://poser.pugx.org/r1pp3rj4ck/lipsum-bundle/license.svg)](https://packagist.org/packages/r1pp3rj4ck/lipsum-bundle) [![Scrutinizer Quality](https://scrutinizer-ci.com/g/r1pp3rj4ck/r1pp3rj4ckLipsumBundle/badges/quality-score.png)](https://scrutinizer-ci.com/g/r1pp3rj4ck/r1pp3rj4ckLipsumBundle/) [![Code Coverage](https://scrutinizer-ci.com/g/r1pp3rj4ck/r1pp3rj4ckLipsumBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/r1pp3rj4ck/r1pp3rj4ckLipsumBundle/?branch=master)

License
-------

This bundle ships with MIT license. Full license available [here](LICENSE)

Installation
------------

### Step 1: Download r1pp3rj4ckLipsumBundle using Composer

Add r1pp3rj4ckLipsumBundle to your composer.json
```js
{
    "require": {
        "r1pp3rj4ck/lipsum-bundle": "dev-master"
    }
}
```

Update your vendors:
```bash
$ php composer.phar update
```

Or you can also install only r1pp3rj4ckLipsumBundle:
```bash
$ php composer.phar update r1pp3rj4ck/lipsum-bundle
```

### Step 2: Register the bundle in your kernel

You shouldn't have any reason to use this bundle in prod environment,
so you can just register it in dev environment:
```php
<?php
// app/AppKernel.php

if (in_array($this->getEnvironment(), array('dev', 'test'))) {
    // ...
    $bundles[] = new r1pp3rj4ck\LipsumBundle\r1pp3rj4ckLipsumBundle();
    // ...
}
```

### (optional) Step 3: Change fixtures

This bundle ships with three fixture files containing 1219 male names,
1000 female names and 1000 last names. You can override these default
files (e.g. frequent for names in your native language) in the configuration.

The files must contain one name per line.

```yml
# app/config_dev.yml

r1pp3rj4ck_lipsum:
    generator:
        profile:
            male_names: src/Acme/DemoBundle/DataFixtures/male_names.txt
            female_names: src/Acme/DemoBundle/DataFixtures/female_names.txt
            last_names: src/Acme/DemoBundle/DataFixtures/last_names.txt
```

### (optional) Step 4: Override the default generator

You can override the default generator by implementing the
`r1pp3rj4ck\LipsumBundle\Generator\GeneratorInterface` interface and add it
to the configuration:

```yml
# app/config_dev.yml

r1pp3rj4ck_lipsum:
    generator:
        class: Acme\DemoBundle\Generator\Generator
```

Services
--------

### `r1pp3rj4ck.lipsum.generator.profile` - generates user data

Usage:
```php
<?php

$profileGenerator = $this->container->get('r1pp3rj4ck.lipsum.generator.profile');

$userData    = $profileGenerator->getUserData(ProfileGenerator::SEX_RANDOM);
$refUserData = array(
  'fullName'   => 'John Doe',
  'firstName'  => 'John',
  'middleName' => '',
  'lastName'   => 'Doe',
  'userName'   => 'john.doe314',
  'email'      => 'john.doe314@gmail.com',
);
// $userData and $refUserData will look like the same but with another data
// ProfileGenerator::getUserData($sex = ProfileGenerator::SEX_RANDOM);
// possible $sex values: SEX_RANDOM, SEX_MALE, SEX_FEMALE

$name    = $profileGenerator->getName(ProfileGenerator::SEX_FEMALE, false)
$refName = array(
  'fullName'   => 'Jane Doe',
  'firstName'  => 'Jane',
  'middleName' => '',
  'lastName'   => 'Doe',
);
// $name and $refName will look like the same but with another data
// ProfileGenerator::getName($sex = ProfileGenerator::SEX_RANDOM, $middleName = false)

$firstName = $profileGenerator->getFirstName(ProfileGenerator::SEX_MALE);
$refFirstName = 'John';

$name        = 'Jane Mary Doe';
$userName    = $profileGenerator->getUserName($name);
$refUserName = 'jane.mary.doe813';
$email       = $profileGenerator->getEmail($userName);
$refEmail    = 'jane.mary.doe813@gmail.com';
```

### `r1pp3rj4ck.lipsum.generator.random` - generates random strings

Usage:
```php
<?php

$randomGenerator = $this->container->get('r1pp3rj4ck.lipsum.generator.random');

$lipsum = $randomGenerator->getRandom(42, RandomGenerator::PUNCTUATION_ON);
// $lipsum will be a 42 words long string, containing punctuation randomly,
// always with a dot on the end.
// possible punctuation values:
// PUNCTUATION_NONE   - no punctuation at all
// PUNCTUATION_AT_END - a dot at the end of string, nowhere else
// PUNCTUATION_ON     - (default) contains punctuation randomly + a dot at the end
```

### `r1pp3rj4ck.lipsum.generator.address` - generates random addresses

Usage:
```php

<?php

$addressGenerator = $this->container->get('r1pp3rj4ck.lipsum.generator.address');

$address = $addressGenerator->getStreetName();
// $address == 'Holly Drive'

$address = $addressGenerator->getAddress();
// $address == array(
//   'streetName'   => 'Holly Drive',
//   'streetNumber' => 242,
//   'fullAddress'  => 'Holly Drive 242',
// );
```

Configuration Reference
-----------------------

This configuration reference contains the default values of everything:

```yml
# app/config_dev.yml

r1pp3rj4ck_lipsum:
    generator:
        profile:
            male_names: vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/malenames.txt
            female_names: vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/femalenames.txt
            last_names: vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/lastnames.txt
            class: r1pp3rj4ck\LipsumBundle\Generator\ProfileGenerator
        random:
            random: vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/lipsum.txt
            class: r1pp3rj4ck\LipsumBundle\Generator\RandomGenerator
        address:
            street_names: vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/streetnames.txt
            class: r1pp3rj4ck\LipsumBundle\Generator\AddressGenerator
```
