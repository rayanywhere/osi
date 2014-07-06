<?php
class Media_ConnectParams
{
}

class Media_ConnectParams_Mysql extends Media_ConnectParams
{
	public $host;
	public $port;
	public $user;
	public $pass;
	public $database;
	public $table;
}

class Media_ConnectParams_Memcache extends Media_ConnectParams
{
	public $host;
	public $port;
	public $prefix;
}

class Media_ConnectParams_Redis extends Media_ConnectParams
{
	public $host;
	public $port;
	public $prefix;
}

class Media
{
	static public function mysqlConnect(Media_ConnectParams_Mysql $params){
		$dsn = 'mysql:host=' . $params->host . ';port=' . $params->port;
		$pdo = new PDO($dsn, $params->user, $params->pass, array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}

	static public function memcacheConnect(Media_ConnectParams_Memcache $params){
		$memcache = new Memcached($params->host . $params->port);
		if(count($memcache->getServerList()) == 0){
			$memcache->addServer($params->host, $params->port);
			$memcache->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
			$memcache->setOption(Memcached::OPT_SERIALIZER, Memcached::SERIALIZER_IGBINARY);
			$memcache->setOption(Memcached::OPT_TCP_NODELAY, true);
		}
		return $memcache;
	}

	static public function redisConnect(Media_ConnectParams_Redis $params){
		$redis = new Redis;
		$redis->pconnect($params->host, $params->port);
		return $redis;
	}
}
