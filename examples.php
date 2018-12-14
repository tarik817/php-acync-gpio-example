<?php

// Init the I/O.
exec('echo 16 > /sys/class/gpio/export');
exec('echo out > /sys/class/gpio/gpio16/direction');
// Work with the I/O.
// (Write.)
exec('echo 1 >  /sys/class/gpio/gpio16/value');
// Re-set I/O purpose.
exec('echo in > /sys/class/gpio/gpio16/direction');
// Read.
exec('cat /sys/class/gpio/gpio16/value');










// Library 'tgeindre/php-gpio' .
$pi = new PhpGpio\Utils\Pi;
$pi->getAvailablePins();

define('PIN_IN', 4);
define('PIN_OUT', 7);

$gpio = new PhpGpio\Gpio([PIN_IN, PIN_OUT]);

$gpio
    // Makes it readable
    ->setup(PIN_IN, PhpGpio\GpioInterface::DIRECTION_IN)
    // Writeable
    ->setup(PIN_OUT, PhpGpio\GpioInterface::DIRECTION_OUT);

// read PIN_IN value and display it
$value = $gpio->read(PIN_IN);

// write 1 on PIN_OUT
$gpio->write(PIN_OUT, PhpGpio\GpioInterface::IO_VALUE_ON);
