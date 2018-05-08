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
        foreach ($config as $name => $value) {
            $this->__set($name, $value);
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

        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            $this->$name = $value;
        }
    }

    public function __isset($name)
    {
        return !empty($this->__get($name));
    }

    public function __get($name)
    {
        if ($name === '$ref') {
            $name = 'ref';
        }
        $getter = 'get' . $name;

        if (method_exists($this, $getter)) {
            return $this->$getter($name);
        }

        return null;
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