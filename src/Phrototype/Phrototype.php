<?php

namespace Phrototype;

class Phrototype {

    private $properties = [];
    private $phrototype = null;

    protected function __construct(self $phrototype = null, $properties = []) {
        foreach($properties as &$property) {
            if($property instanceof \Closure) {
                $property = $property->bindTo($this, $this);
            }
        }
        $this->phrototype = $phrototype;
        $this->properties = $properties;
    }

    public function hasOwnProperty($property) {
        return isset($this->properties[$property]);
    }

    public function properties() {
        $properties = $this->properties;
        if($this->phrototype) {
            $properties = array_merge($properties, $this->phrototype->properties());
        }
        return $properties;
    }

    public function phrototype() {
        if($this->phrototype) {
            return $this->phrototype->phrototype();
        }
    }

    public function __call($fn, $args) {
        if(isset($this->properties[$fn]) && is_callable($this->properties[$fn])) {
            return call_user_func_array($this->properties[$fn], $args);
        } else {
            if($this->phrototype) {
                return call_user_func_array([$this->phrototype, $fn], $args);
            } else {
                throw new \BadMethodCallException();
            }
        }
    }

    public function __set($attr, $value) {
        if($value instanceof \Closure) {
            $value = $value->bindTo($this, $this);
        }
        $this->properties[$attr] = $value;
    }

    public function __get($attr) {
        if(isset($this->properties[$attr])) {
            return $this->properties[$attr];
        } else {
            if($this->phrototype) {
                return $this->phrototype->$attr;
            }
        }
    }

    public static function init($properties = []) {
        return new self(null, $properties);
    }

    public function __invoke($properties = []) {
        return new self($this, $properties);
    }
}
