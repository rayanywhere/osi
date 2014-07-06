<?php
require_once __DIR__ . '/media.class.php';

class Storage
{
	static public function get($key, Media_ConnectParams $connectParams)
	{
		if($connectParams instanceOf Media_ConnectParams_Redis){
			$redis = Media::redisConnect($connectParams);
			return $redis->get($connectParams->prefix . $key);
		}
		else if($connectParams instanceOf Media_ConnectParams_Mysql){
		}
		else{
			throw new Exception('unknown storage type');
		}
	}

	static public function set($key, $value){
		if($connectParams instanceOf Media_ConnectParams_Redis){
			$redis = Media::redisConnect($connectParams);
			return $redis->set($connectParams->prefix . $key, $value);
		}
		else if($connectParams instanceOf Media_ConnectParams_Mysql){
		}
		else{
			throw new Exception('unknown storage type');
		}
	}

	static public function del($key){
		if($connectParams instanceOf Media_ConnectParams_Redis){
			$redis = Media::redisConnect($connectParams);
			return $redis->delete($connectParams->prefix . $key);
		}
		else if($connectParams instanceOf Media_ConnectParams_Mysql){
		}
		else{
			throw new Exception('unknown storage type');
		}
	}
}
