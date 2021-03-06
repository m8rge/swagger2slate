<?php

namespace m8rge\swagger;


class Response extends BaseObject
{
    /**
     * @var Schema
     */
    public $schema;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array
     */
    public $examples;

    public function setSchema($value): void
    {
        $this->schema = new Schema($value);
    }

    public function __toString()
    {
        return (string)$this->schema;
    }
}