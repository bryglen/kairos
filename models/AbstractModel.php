<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\models;

abstract class AbstractModel
{
    public function getAttributes()
    {
        $class = new \ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }

        return $names;
    }

    public function setAttributes($values)
    {
        if (is_array($values)) {
            $attributes = $this->getAttributes();
            foreach ($values as $name => $value) {
                if (isset($attributes[$name])) {
                    $this->$name = $value;
                }
            }
        }
    }
} 