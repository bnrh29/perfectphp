<?php

namespace Project\Module;

require_once 'Foo/Bar/Baz.php';         // Foo\Bar\Bazクラス
require_once 'Hoge/Fuga.php';           // Hoge\Fugaクラス
require_once 'Module/Klass/Some.php';    // Module\Klass\Someクラス

use Foo\Bar as BBB; // BBB
use Hoge\Fuga;      // Fuga

class Piyo
{
    // 未実装
}

$obj1 = new \Directory();   // 完全主食なので、グローバルのDirectoryクラス

$obj2 = new BBB\Baz();      // エイリアスに基づいてコンパイル時にFoo\Bar\Bazクラスとなる

$obj3 = new Fuga();         // インポートルールに基づいてコンパイル時にHoge\Fugaクラスとなる

$obj4 = new Klass\Some();   // 修飾名で該当するインポートルールがないため、コンパイル時に現在の名前空間である
// Project\Moduleが先頭につけられ、Project\Module\Klass\someクラスと解釈される

$obj5 = new Piyo();         // 被修飾名で該当するインポートルールがないため、コンパイル時の変換はない
// 実行時に現在の名前空間が先頭に付与されたProject\Module\Piyoクラスと解釈される

some_func();                // 実行時にProject\Module\some_func()関数を探し、なければグローバル関数を実行

BBB\SOME_CONST;             // コンパイル時にFoo\Bar\SOME_CONST定数に変換される

SOME_CONST;                 // 実行時にProject\Module\SOME_CONSTがなければグローバルのSOME_CONST定数が評価される

$class_name = 'Project\Module\SomeClass';
$obj = new $class_name();

use Project\Module2 as Another;

$class_name = 'Another\SomeClass';  // 文字列のためコンパイル時の変換ができない
$obj = new $class_name();           // new Another\Module\SomeClass()となり、名前解決ができない
