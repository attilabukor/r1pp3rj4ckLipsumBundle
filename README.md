r1pp3rj4ckLipsumBundle
======================

Generates bullshit for fixtures and other uses

[![Build Status](https://secure.travis-ci.org/r1pp3rj4ck/r1pp3rj4ckLipsumBundle.png?branch=master)](http://travis-ci.org/r1pp3rj4ck/r1pp3rj4ckLipsumBundle)

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

Configuration Reference
-----------------------

This configuration reference contains the default values of everything:

```yml
# app/config_dev.yml

r1pp3rj4ck_lipsum:
    generator:
        male_names: vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/malenames.txt
        female_names: vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/femalenames.txt
        last_names: vendor/r1pp3rj4ck/lipsum-bundle/r1pp3rj4ck/LipsumBundle/data/lastnames.txt
        class: r1pp3rj4ck\LipsumBundle\Generator\Generator
```