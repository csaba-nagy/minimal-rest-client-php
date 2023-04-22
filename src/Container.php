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
  private static ?ContainerInterface $instance;

  private array $entries = [];

  public static function getInstance(): ContainerInterface
  {
    return static::$instance ??= new static();
  }

  private function __construct()
  {
  }

  public function get(string $id)
  {
    if ($this->has($id)) {
      $entry = $this->entries[$id];

      if (is_callable($entry)) {
        return $entry($this);
      }

      $id = $entry;
    }

    return $this->resolve($id);
  }

  public function has(string $id): bool
  {
    return isset($this->entries[$id]);
  }

  // To support interfaces, the type of $resolver should be callable or string
  // because when an interface has been added as dependency, it will be registered as a key, and the resolvable class will be the value
  public function set(string $id, callable | string $resolver)
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
