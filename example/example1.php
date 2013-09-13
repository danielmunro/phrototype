<?php

require_once(__DIR__.'/../src/Phrototype/Phrototype.php');


// Passing all properties and methods in the init() call
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


// Dynamically assign a new function
$vehicle->turnOff = function() {
    $this->engine->stop();
};


// Create a truck object from vehicle
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
var_dump($sedan->wheelCount); // 4
echo "\nairbag count: ";
var_dump($sedan->airbagCount); // 6
echo "\nfoobar: ";
var_dump($sedan->foobar); // null -- property does not exist
echo "\n";

$sedan->turnOn();
var_dump($sedan->engine->isOn()); // true
$sedan->turnOff();
var_dump($sedan->engine->isOn()); // false

echo "has properties: ";
var_dump($sedan->hasOwnProperty('engine')); // false
var_dump($sedan->hasOwnProperty('surroundSound')); // true
echo "\nall properties: ";
var_dump($sedan->properties());

echo "\nmethod does not exist exception: ";
$sedan->foo(); // throws a BadMethodCallException
