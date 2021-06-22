<?php

namespace App\DependencyInjection;

use ReflectionClass;
use ReflectionParameter;

class Definition
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var bool
     */
    private bool $shared = true;

    /**
     * @var array
     */
    private array $aliases = [];

    /**
     * @var Definition[]
     */
    private array $dependencies = [];

    /**
     * @var ReflectionClass
     */
    private ReflectionClass $class;


    /**
     * @param string $id
     * @param boolean $shared
     * @param array $aliases
     * @param array $dependencies
     */
    public function __construct(string $id, bool $shared = true, array $aliases = [], array $dependencies = [])
    {
        $this->id = $id;
        $this->shared = $shared;
        $this->aliases = $aliases;
        $this->dependencies = $dependencies;
        $this->class = new ReflectionClass($id);
      
    }


    /**
     * Set the value of shared
     *
     * @param  bool  $shared
     *
     * @return  self
     */
    public function setShared(bool $shared): self
    {
        $this->shared = $shared;
        return $this;
    }

    /**
     * Get the value of shared
     *
     * @return  bool
     */
    public function isShared(): bool
    {
        return $this->shared;
    }


    /**
    
     * @param ContainerInterface $container
     * @return object
     */
    public function newInstance(ContainerInterface $container): object
    {
        $constructor =  $this->class->getConstructor();

        if (null === $constructor) {

            return $this->class->newInstance();
        }
        $parameters = $constructor->getParameters();

        return $this->class->newInstanceArgs(
            array_map(function (ReflectionParameter $param) use ($container) {

                if ($param->getClass() === null) {
                    return $container->getParameter($param->getName());
                }

                return $container->get($param->getClass()->getName());
            }, $parameters)
        );
    }
}
