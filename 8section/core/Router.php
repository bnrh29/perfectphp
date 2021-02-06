<?php
class Router
{
    protected $routes;

    public function __construct($definitions)
    {
        $this->routes = $this->compileRoutes($definitions);
    }

    /*
    $definitions = array(
        '/' => array('controller' => 'status', 'action' => 'index'),
        '/status/post' => array('controller' => 'status', 'action' => 'post'),
        '/user/:user_name' => array('controller' => 'status', 'action' => 'user'),
        '/user/:user_name/status/:id' => array('controller' => 'status', 'action' => 'show'),
        '/account' => array('controller' => 'account', 'action' => 'index'),
        '/account/:action' => array('controller' => 'account'),
        '/follow' => array('controller' => 'account', 'action' => 'follow'),
    )
    */
    public function compileRoutes($definitions)
    {
        $routes = array();

        foreach ($definitions as $url => $params) {
            $tokens = explode('/', ltrim($url, '/'));
            foreach ($tokens as $i => $token) {
                if (0 === strpos($token, ':')) {
                    $name = substr($token, 1);
                    $token = '(?P<' . $name . '>[^/]+)';    // :$name の場合は、名前付きキャプチャで受け取れるようにする :actionの場合はaction名 :controllerの場合はcontroller名として受け取る。その他は通常の値として受け取る
                }
                $tokens[$i] = $token;
            }
            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }

        return $routes;
    }

    public function resolve($path_info)
    {
        if ('/' !== substr($path_info, 0, 1)) {
            $path_info = '/' . $path_info;
        }

        // $path_infoと$patternマッチするかチェック、マッチした場合は、キャプチャした値とparamsをマージ
        foreach ($this->routes as $pattern => $params) {
            if (preg_match('#^' . $pattern . '$#', $path_info, $matched)) {
                $params = array_merge($params, $matched);
                print_r($params);
                return $params;
            }
        }
        return false;
    }
}
