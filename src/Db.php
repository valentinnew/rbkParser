<?php
require_once __DIR__ . '/SingletonTrait.php';
require_once __DIR__ . '/Config.php';

class Db
{
    use SingletonTrait;
    private $dbh;

    protected function init()
    {
        $config = Config::getInstance();
        $dsn = $config->db['dsn'];
        $user = $config->db['user'];
        $password = $config->db['passwd'];

        $this->dbh = new PDO($dsn, $user, $password);
        $this->dbh->exec("set names utf8");
    }

    public function getDbh()
    {
        return $this->dbh;
    }
}