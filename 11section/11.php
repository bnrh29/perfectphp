<?php
/*
class Foo
{
    public $bar;

    public function __clone()
    {
        $this->bar = clone $this->bar;
    }
}

class Bar
{
    public $value;
}

$foo = new Foo();
$foo->bar = new Bar();
$foo->bar->value = 'bar';

$foo2 = clone $foo;             // cloneで複製
$foo2->bar->value = 'baz';      // 

var_dump($foo->bar->value);     // bar
var_dump($foo2->bar->value);    // baz
*/

/*
class MyFilter
{
    public function filter($params)
    {
        # code...
        echo $params;
    }
    public function __invoke($params)
    {
        return $this->filter(($params));
    }
}

$filter = new MyFilter();
//$filter('foo');

array_map(array($filter, 'filter'), array(1, 2, 3));
*/

class MyIterator implements Iterator
{
    private $values = array();

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function rewind()
    {
        reset($this->values);
    }

    public function current()
    {
        return current($this->values);
    }

    public function key()
    {
        return key($this->values);
    }

    public function next()
    {
        return next($this->values);
    }

    public function valid()
    {
        return ($this->current() !== false);
    }
}

class Cart implements IteratorAggregate, ArrayAccess, Countable
{
    private $items = array();

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function getIterator()
    {
        return new MyIterator($this->items);
    }

    public function offsetGet($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }
        return null;
    }

    public function offsetSet($key, $value)
    {
        if (isset($key)) {
            $this->items[$key] = $value;
        } else {
            $this->items[] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    public function count()
    {
        return count($this->items);
    }
}

class CartItem
{
    public $name;
    public $price;
    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

/*
$values = array(1, 2, 3);
$iterator = new MyIterator($values);

foreach ($iterator as $key => $value) {
    echo $key . ":" . $value . "\n";
}
*/

$cart = new Cart();

$cart->addItem(new CartItem('パーフェクトPHP', 3200));
$cart->addItem(new CartItem('パーフェクトJava', 3600));
$cart->addItem(new CartItem('Web+DB', 1480));

$cart[] = new CartItem('HogeHoge', 900);
$cart["huga"] = new CartItem('Huga', 450);

// print_r($cart["huga"]->name);

echo count($cart);
