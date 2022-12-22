<?php

namespace Webmasterskaya\Soap\Base\ClassMap;

use ArrayIterator;
use IteratorAggregate;

class ClassMapCollection implements IteratorAggregate
{
    /**
     * @var array<string, ClassMapInterface>
     */
    private $classMaps = [];

    public function __construct(ClassMapInterface ...$classMaps)
    {
        foreach ($classMaps as $classMap) {
            $this->classMaps[$classMap->getWsdlType()] = $classMap;
        }
    }

    public function set(ClassMapInterface $classMap): self
    {
        $this->classMaps[$classMap->getWsdlType()] = $classMap;

        return $this;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->classMaps);
    }
}