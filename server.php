<?php
require "vendor/autoload.php";

use PhpGpio\Gpio;
use PhpGpio\GpioInterface;
use React\EventLoop\Factory;

// Define variables.
define('PIN_1', 4);
define('PIN_2', 7);
$pin1ToggleState = 1;
$pin2ToggleState = 1;

$loop = Factory::create();

$gpio = new Gpio([PIN_1, PIN_2]);
$gpio->setup(PIN_1, GpioInterface::DIRECTION_OUT)
    ->setup(PIN_2, GpioInterface::DIRECTION_OUT);

$loop->addPeriodicTimer(1, function () use ($gpio, &$pin1ToggleState) {
    $gpio->write(PIN_1, $pin1ToggleState);
    ($pin1ToggleState) ? $pin1ToggleState = 0 : $pin1ToggleState = 1;
});

$loop->addPeriodicTimer(5, function () use ($gpio, &$pin2ToggleState){
    $gpio->write(PIN_1, $pin2ToggleState);
    ($pin2ToggleState) ? $pin2ToggleState = 0 : $pin2ToggleState = 1;
});

$loop->run();
