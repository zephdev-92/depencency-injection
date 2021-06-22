<?php

namespace App\DependencyInjection;
use Psr\Container\ContainerInterface as PsrContainerContainerInterface ;

interface ContainerInterface extends PsrContainerContainerInterface
{
    /**
     * @param string $id
     * @return self
     */
    public function register(string $id): self;

    /**
     * @param $id
     * @return Definition
     */
    public function getDefinition($id): Definition;

    /**
     * @param  $id
     * @param  $value
     * @return self
     */
    public function addParameter($id, $value): self;

    /**
     * @param $id
     * @return void
     */
    public function getParameter($id);

    /**
     * @param string $id
     * @param string $class
     * @return $this
     */
    public function addAlias(string $id, string $class): self;
}