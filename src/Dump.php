<?php
/**
 * Dump an object out to a self-contained HTML document.
 *
 * @package Dumpster
 * @author Eric
 */
namespace Dumpster;

class Dump
{
    /**
     * @var \Mustache_Engine
     */
    private $mustache;

    /**
     * @var ObjectDefinition
     */
    private $contextObject;

    /**
     * @var bool
     */
    private $proceed = true;

    /**
     * Dump constructor.
     * @param $contextObject
     *
     * @return $this
     */
    public function __construct($contextObject)
    {
        $suppression = getenv('DUMPSTER_SUPPRESS');
        if (!empty($suppression)) $this->proceed = false;

        if (empty($this->proceed))
        {
            return $this;
        }

        if (class_exists('\Mustache_Engine'))
        {
            $this->mustache = new \Mustache_Engine([
                'loader' => new \Mustache_Loader_FilesystemLoader(__DIR__ . '/../resources/templates'),
                'partials_loader' => new \Mustache_Loader_FilesystemLoader(__DIR__ . '/../resources/templates/partials')
            ]);
        }

        $this->contextObject = new ObjectDefinition('', $contextObject);

        return $this;
    }

    /**
     * Output the dump contents
     *
     * @return $this
     */
    public function output()
    {
        if (empty($this->proceed))
        {
            return $this;
        }

        if (!empty($this->mustache))
        {
            $output = $this->mustache->render('dump.mustache', ['object'=>$this->contextObject]);
        }
        else
        {
            $output = 'Some text representation when mustache is not available.';
        }

        echo $output;

        die();
    }
}
