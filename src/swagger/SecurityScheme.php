<?php

namespace m8rge\swagger;


class SecurityScheme extends BaseObject
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $name;
    
    /**
     * @var string
     */
    public $in;
}