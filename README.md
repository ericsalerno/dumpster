# dumpster

PHP Object Dump Utility

## Object Dump Usage

You can dump the contents of an object simply by creating a dump object and performing output() on it. For example:

    new \Dumpster\Dump($myDumpableObject)->output();

This should work with all scalar, array, or object values.

## Environment-Level Dump Suppression

You can turn-off the Dumpster utility on an entire environment if the environment variable DUMPSTER_SUPPRESS is a non-zero value.

