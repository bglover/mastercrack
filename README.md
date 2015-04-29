# MasterCrack

A PHP class to calculate the combination for a masterlock using a technique
discovered by [Samy Kamkar](http://null-byte.wonderhowto.com/how-to/crack-any-master-combination-lock-8-tries-less-using-calculator-0161629/)


# Installation
```sh
composer require access9\mastercrack
```


# Usage Example

```php
#!env php
<?php
require_once 'vendor/autoload.php';

$m = new Access9\MasterCrack();

echo 'Lock Position First: ';
$m->lp1 = trim(fgets(STDIN));

echo 'Lock Position Second: ';
$m->lp2 = trim(fgets(STDIN));

echo '       Resistance: ';
$m->resist = trim(fgets(STDIN));

// Calculate the combination.
$m->calc();

echo PHP_EOL, 'first: ',  $m->getFirst(), PHP_EOL;
echo 'second: ', implode(', ', $m->getSecond()), PHP_EOL;
echo 'third: ',  implode(', ', $m->getThird()), PHP_EOL;
```
