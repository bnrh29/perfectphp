<?php
// オートロード
class ClassLoader
{
    protected $dirs;


    public function register()
    {
        //$thisを渡すとloadClassメソッド中でインスタンスにアクセスできる
        spl_autoload_register(array($this, 'loadClass'));
    }

    // オートロード対象のディレクトリを追加
    public function registerDir($dir)
    {
        $this->dirs[] = $dir;
    }

    // 実際にオートロード
    public function loadClass($class)
    {
        // 対象ディレクトリにクラス名のファイルがあれば読み込み
        foreach ($this->dirs as $dir) {
            $file = $dir . '/' . $class . '.php';
            if (is_readable($file)) {
                require $file;
                return;
            }
        }
    }
}
