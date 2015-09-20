# Quickstart

Defines common way to bootstrap a Nette-powered application.

## Installation

Install the package using [Composer](http://getcomposer.org/):

```sh
$ composer require jr/bootstrapped
```

## Usage

Boot the application using System Container returned by `JR\Bootstrapped\Bootstrapper::boot()` method:

```php
<?php

// example usage (index.php)

$appDir = __DIR__;
$autoLoader = require $appDir . '/vendor/autoload.php';

// boot options
$options = new \JR\Bootstrapped\Options();
$options->setAppDirectory($appDir);
$options->setLogDirectory($appDir . '/log');
$options->setTempDirectory($appDir . '/temp');
$options->setErrorNotificationEmail('developer@localhost.com');

// note that passing NULL results in creation of default options
$bootstrapper = new \JR\Bootstrapped\Bootstrapper($options);

// create System Container
$container = $bootstrapper->boot();

// actually run the Application
$container->getByType('Nette\Application\Application')->run();
```

For complete list of available options, see [JR\Bootstrapped\Options](https://github.com/rebendajirijr/bootstrapped/blob/master/src/JR/Bootstrapped/Options.php).
