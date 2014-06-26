<?php
class Object
{
	public function __construct($json = null){
		$data = null;
		if(is_string($json))
			$data = json_decode($json, true);
		else if(is_array($json))
			$data = $json;

		if(is_array($data)){
			foreach($this as $k => &$v){
				if(isset($data[$k])){
					if(is_object($v)){
						$targetClass = get_class($v);
						$v = new $targetClass($data[$k]);
					}
					else
						$v = $data[$k];
				}
			}
		}
	}

	public function toJSON(){
		return json_encode($this);
	}
}
