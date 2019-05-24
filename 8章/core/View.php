<?php
/*
Viewのrenderがいまいち理解できていない
*/


class View
{
    protected $base_dir;
    protected $defaults;
    protected $layout_valiables = array();

    public function __construct($base_dir, $defaults = array())
    {
        $this->base_dir = $base_dir;
        $this->defaults = $defaults;
    }

    public function setLayoutVar($name, $value)
    {
        $this->layout_valiables[$name] = $value;
    }

    public function render($_path, $_variables = array(), $_layout = false)
    {
        $_file = $this->base_dir . '/' . $_path . '.php';

        // 配列のキーを変数名として変数を作成
        extract(array_merge($this->defaults, $_variables));

        ob_start();             // 出力をバッファリング
        ob_implicit_flush(0);   // 自動フラッシュを無効

        // viewファイルを読み込み
        require $_file;

        $content = ob_get_clean();  // バッファを取得して削除

        // 親レイアウトがあれば親レイアウトをレンダー
        if ($_layout) {
            $content = $this->render(
                $_layout,
                array_merge(
                    $this->layout_valiables,
                    array('_content' => $content,)
                )
            );
        }
        return $content;
    }

    public function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
