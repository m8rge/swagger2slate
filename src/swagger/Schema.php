<?php

namespace m8rge\swagger;


class Schema extends BaseObject
{
    /**
     * @var string
     */
    public $type = 'object';

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $format;

    /**
     * @var string
     */
    public $description;

    /**
     * @var Schema
     */
    public $items;

    /**
     * @var Schema[]
     */
    public $properties = [];

    /**
     * @var string[]
     */
    public $enum = [];

    /**
     * @var string[]
     */
    public $required = [];

    protected $isRef;

    public function setItems($value): void
    {
        $this->items = new self($value);
    }

    public function setRequired($value): void
    {
        $this->required = array_merge($this->required, $value);
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toString($md = true): string
    {
        if ($this->title) {
            return $this->isRef && $md ? "[$this->title](#" . strtolower($this->title) . ')' : $this->title;
        }

        if ($this->type === 'array') {
            return 'array[' . $this->items->toString($md) . ']';
        }

        return $this->type;
    }

    public function setRef($value): void
    {
        $value = str_replace('#/', '', $value);
        $pathEntries = explode('/', $value);

        $array = Swagger::$root;
        foreach ($pathEntries as $entry) {
            $array = $array[$entry];
        }

        if (!array_key_exists('title', $array)) {
            if (!$this->title) {
                $array['title'] = end($pathEntries);
            }
            if (null === $this->isRef) {
                $array['isRef'] = true;
            }
        }
        $this->setConfig($array);
    }

    public function setAllOf($value): void
    {
        $this->title = 'object';
        $this->isRef = false;
        foreach ($value as $schema) {
            $this->setConfig($schema);
        }
    }

    public function setProperties($value): void
    {
        foreach ($value as $name => $obj) {
            $this->properties[$name] = new self($obj);
        }
    }

    public function getObject()
    {
        if ($this->properties) {
            $res = [];
            foreach ($this->properties as $name => $schema) {
                if ($schema->type === 'object') {
                    $res[$name] = $schema->getObject();
                } elseif ($schema->type === 'array') {
                    $res[$name] = [$schema->items->getObject()];
                } else {
                    $res[$name] = $schema->type;
                }
            }
            return $res;
        }

        if ($this->type === 'object') {
            # an object with no defined properties
            return $this->type;
        }

        if ($this->type === 'array') {
            return [$this->items->getObject()];
        }

        return $this->type;
    }

    public function getPropertiesDescription(): array
    {
        $res = [];
        foreach ($this->properties as $name => $schema) {
            $res[$name] = $schema->description ?: (string)$schema;
        }

        return $res;
    }
}