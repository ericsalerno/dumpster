# dumpster

PHP Object Dump Utility. We all know the only way to debug your code is to step-through it with a debugger, like xdebug. Every now and then you end up in a situation where for some reason you can't and you have to fall back on your baser instincts and dump out object data. But var_dump and print_r can be ugly or overwhelming. That's where dumpster comes in.

## Object Dump Usage

You can dump the contents of an object simply by creating a dump object and performing output() on it. For example:

    new \Dumpster\Dump($myDumpableObject)->output();

This should work with all scalar, array, or object values.

## Environment-Level Dump Suppression

You can turn-off the Dumpster utility on an entire environment if the environment variable DUMPSTER_SUPPRESS is a non-zero value.

