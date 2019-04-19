<?php
class DbManager
{
    protected $connections = array();               // DB接続先を配列で保持
    protected $repository_connection_map = array(); // repositoryでどの接続先を使うか配列に保存
    protected $repositories = array();              // 

    // PDO接続
    public function connect($name, $params)
    {
        $params = array_merge(array(
            'dns' => null,
            'user' => '',
            'password' => 'null',
            'options' => array(),
        ), $params);

        $con = new PDO(
            $params['dns'],
            $params['user'],
            $params['password'],
            $params['options']
        );

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connections[$name] = $con;
    }

    // 接続先を取得
    public function getConnection($name = null)
    {
        if (is_null($name)) {
            return current($this->connections);
        }

        return $this->connections[$name];
    }

    // repository と 接続先をマッピング
    public function setRepositoryConnectionMap($repository_name, $name)
    {
        $this->repository_connection_map[$repository_name] = $name;
    }

    // repositoryから接続先を取得する
    public function getConnectionForRepository($repository_name)
    {
        if (isset($this->repository_connection_map[$repository_name])) {
            $name = $this->repository_connectoin_map[$repository_name];
            $con = $this->getConnection($name);
        } else {
            $con = $this->getConnection();
        }
        return $con;
    }

    // repositoryを取得
    public function get($repository_name)
    {
        if (!isset($this->repositories[$repository_name])) {
            $repository_class = $repository_name . 'Repository';
            $con = $this->getConnectionForRepository($repository_name);

            $repository = new $repository_class($con);
            $this->repositories[$repository_name] = $repository;
        }

        return $this->repositories[$repository_name];
    }

    public function __destruct()
    {
        foreach ($this->repositories as $repository) {
            unset($repository);
        }

        foreach ($this->connections as $con) {
            unset($con);
        }
    }
}
