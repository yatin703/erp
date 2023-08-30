<?php
require APPPATH . '/libraries/JWT.php';
class ImplementJWT
{
	
	PRIVATE $key='Eknath Bhagwat Parkhe 12345678910';
	
	// This function Generates token-----------------------
	public function GenerateToken ($data){
		$jwt=JWT::encode($data,$this->key);
		return $jwt;
	}
	// This function decode the token-----------------------
	public function DecodeToken ($token){
		$decoded=JWT::decode($token,$this->key,array('HS256'));
		$decodeData=(array)$decoded;
		return $decodeData;
	}
}
	

?>

