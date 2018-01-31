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
     * @var int
     */
    private $level = 0;

    /**
     * @var bool
     */
    private $specialMap = false;

    /**
     * ObjectDefinition constructor.
     *
     * @param $name
     * @param $object
     * @param $level
     */
    public function __construct($name, $object, $level)
    {
        $this->name = $name;
        $this->level = $level;

        if (is_array($object))
        {
            $this->type = 'array';
            $this->value = 'Array';
            $this->children = [];

            foreach ($object as $key => $value)
            {
                $subObject = new ObjectDefinition($key, $value, $this->level + 1);
                $this->children[] = $subObject;
            }
        }
        else if (is_object($object))
        {
            $this->type = 'object';
            $this->value = get_class($object);

            if ($object instanceof \DateTime)
            {
                $this->children = [new ObjectDefinition('Atom Format', $object->format(DATE_ATOM), $this->level + 1)];
            }
            else
            {
                $this->children = [];

                foreach ($object as $key => $value)
                {
                    $subObject = new ObjectDefinition($key, $value, $this->level + 1);
                    $this->children[] = $subObject;
                }
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

            if (filter_var($this->value, FILTER_VALIDATE_EMAIL))
            {
                $this->type .= ' (email)';
                $this->value = '<a href="mailto:' . $this->value . '">' . $this->value . '</a>';
                $this->specialMap = true;
            }
            elseif (filter_var($this->value, FILTER_VALIDATE_URL))
            {
                $this->type .= ' (url)';
                $this->value = '<a href="' . $this->value . '" target="_blank">' . $this->value . '</a>';
                $this->specialMap = true;
            }
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

    /**
     * @return bool
     */
    public function isRoot()
    {
        return ($this->level == 0);
    }

    /**
     * @return bool
     */
    public function printRaw()
    {
        return $this->specialMap;
    }
}