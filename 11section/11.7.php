<?php

class ClassLoader
{
    private $namespaces = array();

    public function __construct($namespaces = array())
    {
        $this->namespaces = $namespaces;
    }

    public function registerNamespace($namespaces, $dir)
    {
        $this->namespaces[$namespaces] = $dir;
    }

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function loadClass($class)
    {
        $class = ltrim($class, '\\');

        if (false !== ($pos = strpos($class, '\\'))) {
            $namespace = substr($class, 0, $pos);
            $class = substr($class, $pos + 1);

            foreach ($this->namespaces as $ns => $dir) {
                if (0 === strpos($namespace, $ns)) {
                    $path = $dir . DIRECTORY_SEPARATOR
                        . str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
                        . DIRECTORY_SEPARATOR
                        . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

                    if (is_file($path)) {
                        require $path;

                        return true;
                    }
                }
            }
        } else if (isset($this->namespaces[''])) {
            $dir = $this->namespaces[''];
            $path = $dir . DIRECTORY_SEPARATOR
                . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

            if (is_file($path)) {
                require $path;

                return true;
            }
        }
    }
}

require '/path/to/ClassLoad.php';

$loader = new ClassLoader(array(
    'Foo' => '/path/to/src',
    '' => '/path/to/src',
));
$loader->register();

new Foo\Bar();          // => /path/to/src/Foo/Bar.php を読み込む
new Foo\Bar\Baz();      // => /path/to/src/Foo/Bar/Baz.php を読み込む
new Unknown\Baz();      // => Unknown名前空間が設定されていないので何も読み込まない
new Hoge_Fuga();        // => /path/to/src/Hoge/Fuga.php を読み込む
