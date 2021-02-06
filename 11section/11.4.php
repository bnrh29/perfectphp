<?php

class Cart
{
    private $items = array();

    public function order()
    {
        if (count($this->items) === 0) {
            throw new LogicException('This cart has no items');
        }
    }

    public function add(Item $item, $quantity)
    {
        if (!$item->isAvailableForSale()) {
            throw new InvalidArgumentException('Item is not available for sale');
        }
    }
}

class FileSaver
{
    public function save($file, $text)
    {
        $dir = dirname($file);
        if (is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new RuntimeException('Cannot make directory ' . $dir);
            }
        }
    }
}

class Delegator
{
    private $object;

    public function __construct($object)
    {
        if (!is_object($object)) {
            throw new InvalidArgumentException('Argument must be an object');
        }

        $this->object = $object;
    }

    public function __call($method, $args)
    {
        if (!method_exists($this->object, $method)) {
            throw new BadMethodCallException('ああCall to undefind method ' . $method);
        }

        return call_user_func_array(array($this->object, $method), $args);
    }
}

class Foo
{
    public function bar()
    {
        var_dump(__METHOD__);
    }
}

try {
    $delegator = new Delegator(new Foo());
    $delegator->bar();
    $delegator->unknown();
} catch (Exception $e) {
    //    var_dump($e);
}
