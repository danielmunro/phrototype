<?php

require_once(__DIR__.'/../src/Phrototype/Phrototype.php');

class Engine extends Phrototype\Phrototype {}

$engine = Phrototype\Phrototype::init([
    'on' => false,
    'start' => function() {
        $this->on = true;
    },
    'stop' => function() {
        $this->on = false;
    },
    'isOn' => function() {
        return $this->on;
    }
]);

$vehicle = Phrototype\Phrototype::init([
    'engine' => $engine,
    'wheelCount' => 4,
    'towingCapacity' => 0,
    'turnOn' => function() use (&$vehicle) {
        $vehicle->engine->start();
    }
]);
$vehicle->turnOff = function() {
    $this->engine->stop();
};

$truck = $vehicle([
    'tailHitch' => true
]);
$truck->towingCapacity = 10000;

$boat = $vehicle([
    'floats' => true,
    'wheelCount' => 0
]);

$car = $vehicle([
    'airbagCount' => 6
]);

$sedan = $car([
    'surroundSound' => true
]);

echo "Sedan details:\n";
echo "wheel count: ";
var_dump($sedan->wheelCount);
echo "\nairbag count: ";
var_dump($sedan->airbagCount);
echo "\nfoobar: ";
var_dump($sedan->foobar);
echo "\n";

$sedan->turnOn();
var_dump($sedan->engine->isOn());
$sedan->turnOff();
var_dump($sedan->engine->isOn());

$sedan->foo();
