<?php
require_once __DIR__ . '/media.class.php';

class Cache
{
	static public function get($key, Media_ConnectParams $connectParams)
	{
		if($connectParams instanceOf Media_ConnectParams_Memcache){
			$memcache = Media::memcacheConnect($connectParams);
			return $memcache->get($connectParams->prefix . $key);
		}
		else if($connectParams instanceOf Media_ConnectParams_Redis){
			$redis = Media::redisConnect($connectParams);
			return $redis->get($connectParams->prefix . $key);
		}
		else{
			throw new Exception('unknown cache type');
		}
	}

	static public function set($key, $value, Media_ConnectParams $connectParams){
		if($connectParams instanceOf Media_ConnectParams_Memcache){
			$memcache = Media::memcacheConnect($connectParams);
			return $memcache->set($connectParams->prefix . $key, $value);
		}
		else if($connectParams instanceOf Media_ConnectParams_Redis){
			$redis = Media::redisConnect($connectParams);
			return $redis->set($connectParams->prefix . $key, $value);
		}
		else{
			throw new Exception('unknown cache type');
		}
	}

	static public function del($key, Media_ConnectParams $connectParams){
		if($connectParams instanceOf Media_ConnectParams_Memcache){
			$memcache = Media::memcacheConnect($connectParams);
			return $memcache->delete($connectParams->prefix . $key);
		}
		else if($connectParams instanceOf Media_ConnectParams_Redis){
			$redis = Media::redisConnect($connectParams);
			return $redis->delete($connectParams->prefix . $key);
		}
		else{
			throw new Exception('unknown cache type');
		}
	}
}
