<?php
namespace Mbright\Traits;

trait ToArray
{
    public function toArray()
    {
        $refl = new \ReflectionObject($this);
        $properties = $refl->getProperties();
        $output = [];
        foreach ($properties as $property) {
            if ($property->isStatic() === true) {
                continue;
            }
            $property->setAccessible(true);
            $output[$property->getName()] = $property->getValue($this);
        }
        return $output;
    }
}