<?php
$param = getopt('',['url:']);
if (!isset($param['url']) || !$param['url'] || !is_string($param['url'])) {
    echo "Please provide --url parameter \n";
    die;
}

require "vendor/autoload.php";

use React\EventLoop\Factory;
use React\Filesystem\Filesystem;

// Define variables.
$url = $param['url'];
$DSPin = '';
$LEDRegularBlinkPin = '';
$LEDSendDataBlinkPin = '';
$pinToggleState = 1;
$filePath = './test.txt';
$counter = 1;

$loop = Factory::create();
$filesystem = Filesystem::create($loop);

$DSValuePath = new \App\PinInit($filesystem, $DSPin, 'in');
$LEDSendDataPath = new \App\PinInit($filesystem, $DSPin, 'out');
$LEDRegularBlinkPath = new \App\PinInit($filesystem, $DSPin, 'out');

$loop->addPeriodicTimer(5, function () use ($filesystem, $filePath){
    $filesystem->file($filePath)->open('w')->then(function ($stream) {
        $stream->write(1);
        $stream->end();
    });
    echo 'Timer' . PHP_EOL;
});

$loop->addPeriodicTimer(1, function () use ($filesystem, $LEDRegularBlinkPin, &$pinToggleState) {
    $filesystem->file($LEDRegularBlinkPin)->putContents($pinToggleState);
    ($pinToggleState) ? $pinToggleState = 0 : $pinToggleState = 1;
});

$loop->run();