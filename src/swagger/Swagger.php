<?php

namespace m8rge\swagger;


class Swagger extends BaseObject
{
    public static $root;

    /**
     * @var string
     */
    public $swagger;

    /**
     * @var mixed
     */
    public $info;

    /**
     * @var string
     */
    public $basePath;

    /**
     * @var string
     */
    public $host;

    /**
     * @var string[]
     */
    public $schemes;

    /**
     * @var string[]
     */
    public $consumes;

    /**
     * @var string[]
     */
    public $produces;

    /**
     * @var mixed
     */
    public $paths;

    /**
     * @var mixed
     */
    public $definitions;

    /**
     * @var Response[]
     */
    public $responses;

    /**
     * @var SecurityScheme[]
     */
    public $securityDefinitions;

    /**
     * @var mixed
     */
    public $tags;

    public function setSecurityDefinitions($config): void
    {
        $this->securityDefinitions = [];
        foreach ($config as $name => $innerConfig) {
            $this->securityDefinitions[$name] = new SecurityScheme($innerConfig);
        }
    }

    public function setResponses($config): void
    {
        $this->responses = [];
        foreach ($config as $name => $innerConfig) {
            $this->responses[$name] = new Response($innerConfig);
        }
    }

    public function getPathsByTag($tag): array
    {
        $methods = ['get', 'post', 'put', 'delete', 'options', 'head', 'path'];
        $res = [];
        foreach ($this->paths as $endPoint => $pathItem) {
            foreach ($methods as $method) {
                if (array_key_exists($method, $pathItem) &&
                    array_key_exists('tags', $pathItem[$method]) &&
                    in_array($tag, $pathItem[$method]['tags'], true)
                ) {
                    $res[$endPoint][$method] = $pathItem[$method];
                }
            }
        }

        return $res;
    }
}