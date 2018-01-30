<?php
/**
 * ObjectDefinition class
 *
 * @package Dumpster
 * @author Eric
 */
namespace Dumpster;

class ObjectDefinition
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var ObjectDefinition[]
     */
    private $children = [];

    /**
     * ObjectDefinition constructor.
     *
     * @param $name
     * @param $object
     */
    public function __construct($name, $object)
    {
        $this->name = $name;

        if (is_array($object))
        {
            $this->type = 'array';
            $this->value = 'Array';
            $this->children = [];

            foreach ($object as $key => $value)
            {
                $subObject = new ObjectDefinition($key, $value);
                $this->children[] = $subObject;
            }
        }
        else if (is_object($object))
        {
            $this->type = 'object';
            $this->value = get_class($object);
            $this->children = [];

            foreach ($object as $key => $value)
            {
                $subObject = new ObjectDefinition($key, $value);
                $this->children[] = $subObject;
            }
        }
        elseif (empty($object))
        {
            $this->value = null;
            $this->type = 'null';
        }
        else
        {
            if (is_string($object))
            {
                $this->type = 'string';
            }
            elseif (is_numeric($object) || is_integer($object) || is_float($object) || is_double($object))
            {
                $this->type = 'number';
            }
            elseif (is_bool($object))
            {
                $this->type = 'boolean';
            }
            elseif (is_resource($object))
            {
                $this->type = 'resource';
            }
            else
            {
                $this->type = 'scalar';
            }

            $this->value = (string)$object;
        }
    }

    /**
     * @return bool
     */
    public function isArray()
    {
        return $this->type == 'array';
    }

    /**
     * @return bool
     */
    public function isObject()
    {
        return $this->type == 'object';
    }

    /**
     * @return bool
     */
    public function isNull()
    {
        return $this->type == 'null';
    }

    /**
     * @return bool
     */
    public function isScalar()
    {
        return !$this->isArray() && !$this->isObject();
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return $this->isArray() || $this->isObject();
    }

    /**
     * @return array|ObjectDefinition[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return count($this->children);
    }

    /**
     * @return mixed|string
     */
    public function getValue()
    {
        if ($this->type == 'boolean')
        {
            return $this->value ? 'true' : 'false';
        }

        return $this->value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}