<?php
/*
array(
    '/' 
        => array(
            'controller' => 'home',     // コントローラ名
            'action' => 'index'         // アクション名
        ),
    '/user/edit' 
        => array(
            'controller' => 'user', 
            'action' => 'edit'
        ),
);

array(
    '/user/:id'
        => array(
            'controller' => 'user', 
            'action' => 'show'
        ),
);
array(
    '/:controller'
        => array('action' => 'index'),
    '/item/:action'
        => array('controller' => 'item'),
);
*/
class Router
{
    protected $routes;

    public function __construct($definitions)
    {
        $this->routes = $this->compileRoutes($definitions);
    }

    public function compileRoutes($definitions)
    {
        $routes = array();

        foreach ($definitions as $url => $params) {
            $tokens = explode('/', ltrim($url, '/'));
            foreach ($tokens as $i => $token) {
                if (0 === strpos($token, ':')) {
                    $name = substr($token, 1);
                    $token = '(?P<' . $name . '>[^/]+)';
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

        foreach ($this->routes as $pattern => $params) {
            if (preg_match('#^' . $pattern . '$#', $path_info, $matched)) {
                $params = array_merge($params, $matched);
                return $params;
            }
        }
        return false;
    }
}
