<?php
require_once __DIR__ . '/cache.class.php';
require_once __DIR__ . '/storage.class.php';

class Router
{
	static protected _getCacheConnectParams($key){
		return null;
	}

	static protected _getStorageConnectParams($key){
		return null;
	}

	static public function get($key)
	{
		$cacheConnectParams = self::_getCacheConnectParams($key);
		$storageConnectParams = self::_getStorageConnectParams($key);
		if(!isset($cacheConnectParams) && !isset($storageConnectParams))
			throw new Exception('No cache & storage configured');
		
		$value = null;
		if(isset($cacheConnectParams))
			$value = Cache::get($key, $cacheConnectParams);

		if(!isset($value) && isset($storageConnectParams))
			$value = Storage::get($key, $storageConnectParams);

		return $value;
	}

	static public function set($key, $value){
		$cacheConnectParams = self::_getCacheConnectParams($key);
		$storageConnectParams = self::_getStorageConnectParams($key);
		if(!isset($cacheConnectParams) && !isset($storageConnectParams))
			throw new Exception('No cache & storage configured');

		if(isset($cacheConnectParams))
			Cache::set($key, $value, $cacheConnectParams);

		if(isset($storageConnectParams))
			Storage::set($key, $value, $storageConnectParams);
	}

	static public function del($key){
		$cacheConnectParams = self::_getCacheConnectParams($key);
		$storageConnectParams = self::_getStorageConnectParams($key);
		if(!isset($cacheConnectParams) && !isset($storageConnectParams))
			throw new Exception('No cache & storage configured');

		if(isset($cacheConnectParams))
			Cache::del($key, $cacheConnectParams);

		if(isset($storageConnectParams))
			Storage::del($key, $storageConnectParams);
	}
}
