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
			$pdo = Media::mysqlConnect($connectParams);
			$stmt = $pdo->prepare('SELECT data FROM ' . $connectParams->database . '.' . $connectParams->table . ' WHERE id=:id');
            $stmt->bindValue(':id', $key);
            $stmt->execute();
            if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                return $row['data'];
            }
			return null;
		}
		else{
			throw new Exception('unknown storage type');
		}
	}

	static public function set($key, $value, Media_ConnectParams $connectParams){
		if($connectParams instanceOf Media_ConnectParams_Redis){
			$redis = Media::redisConnect($connectParams);
			return $redis->set($connectParams->prefix . $key, $value);
		}
		else if($connectParams instanceOf Media_ConnectParams_Mysql){
			$pdo = Media::mysqlConnect($connectParams);
            $stmt = $pdo->prepare('REPLACE INTO ' . $connectParams->database . '.' . $connectParams->table . ' set id=:id, data=:data');
            $stmt->bindValue(':id', $key);
            $stmt->bindValue(':data', $value);
            $stmt->execute();
		}
		else{
			throw new Exception('unknown storage type');
		}
	}

	static public function del($key, Media_ConnectParams $connectParams){
		if($connectParams instanceOf Media_ConnectParams_Redis){
			$redis = Media::redisConnect($connectParams);
			return $redis->delete($connectParams->prefix . $key);
		}
		else if($connectParams instanceOf Media_ConnectParams_Mysql){
			$pdo = Media::mysqlConnect($connectParams);
            $stmt = $pdo->prepare('DELETE FROM ' . $connectParams->database . '.' . $connectParams->table . ' WHERE id=:id');
            $stmt->bindValue(':id', $key);
            $stmt->execute();
		}
		else{
			throw new Exception('unknown storage type');
		}
	}
}
