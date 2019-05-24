<?php

// オートロード
require 'core/ClassLoader.php';

$loader = new ClassLoader();
$loader->registerDir(dirname(__FILE__) . '/core');      // coreディレクトリを対象にする
$loader->registerDir(dirname(__FILE__) . '/models');    // modelsディレクトリを対象にする
$loader->register();                                    // オートロードを登録

