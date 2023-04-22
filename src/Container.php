<?php

namespace App\MinimalRestClientPhp;

use App\MinimalRestClientPhp\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class Container implements ContainerInterface
{
  private array $entries = [];

  public function get(string $id)
  {
    if ($this->has($id)) {
      $entry = $this->entries[$id];

      return $entry($this);
    }

    return $this->resolve($id);
  }

  public function has(string $id): bool
  {
    return isset($this->entries[$id]);
  }

  public function set(string $id, callable $resolver)
  {
    $this->entries[$id] = $resolver;
  }

  public function resolve(string $id)
  {
    $reflectionClass = new ReflectionClass($id);

    if (!$reflectionClass->isInstantiable()) {
      throw new ContainerException("Class {$id} is not instantiable!");
    }

    $constructor = $reflectionClass->getConstructor();
    $parameters = $constructor ? $constructor->getParameters() : null;

    if (!$constructor || empty($parameters)) {
      return new $id;
    }

    $dependencies = array_map(function (ReflectionParameter $param) use ($id) {
      $name = $param->getName();
      $type = $param->getType();

      if (!$type) {
        throw new ContainerException("Failed to resolve class {$id}, because {$name} is missing type hint!");
      }

      // This container implementation does not support union types for now.
      if ($type instanceof ReflectionUnionType) {
        throw new ContainerException("Failed to resolve class {$id}, because union type is not supported!");
      }

      if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
        throw new ContainerException("Failed to resolve class {$id} because of invalid param {$name}!");
      }

      return $this->get($type->getName());
    }, $parameters);

    return $reflectionClass->newInstanceArgs($dependencies);
  }
}
