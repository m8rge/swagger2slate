<?php

namespace m8rge\swagger;


class BaseObject // implements ArrayAccess
{
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
        $this->init();
    }

    public function init(): void
    {
        
    }

    public function setConfig(array $config = []): void
    {
        if (!empty($config)) {
            foreach ($config as $name => $value) {
                $this->__set($name, $value);
            }
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if ($name === '$ref') {
            $name = 'ref';
        }
        $setter = 'set' . $name;

        $this->$setter($value);
    }

    public function __isset($name)
    {
        if ($name === '$ref') {
            $name = 'ref';
        }
        $setter = 'set' . $name;

        return method_exists($this, $setter);
    }

    public function __get($name)
    {
        if ($name === '$ref') {
            $name = 'ref';
        }
        $setter = 'get' . $name;

        return method_exists($this, $setter);
    }


//    public function offsetExists($offset)
//    {
//        property_exists($this, $offset);
//    }
//
//    public function offsetGet($offset)
//    {
//        return $this->$offset;
//    }
//
//    public function offsetSet($offset, $value)
//    {
//        $this->__set($offset, $value);
//    }
//
//    public function offsetUnset($offset)
//    {
//        $this->__set($offset, null);
//    }
}