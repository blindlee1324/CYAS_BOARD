<?php

namespace Model;

class User{
	/*
		@param string $id
		@return array(or false if the result is an empty set)
	*/
	public static function findwithId($id) {
		$pdo = new Connection();
		$sql = 'SELECT * FROM users WHERE id = ' . $id . ' limit 1';
		$stmt = $pdo->query($sql);
		$result = $stmt->fetch();
		
		$stmt = null;
		$pdo = null;
		
		return $result;
	}
	
	/*
		@param string $id
		@param string $screen_id
		@param string $name
		@param string $image
		@param string $profile
		@return boolean
	*/
	public static function insert($id, $screen_id, $name, $image, $profile) {
		$pdo = new Connection();
		
		$data = [
			'id' => $id,
			'screen_id' => $screen_id,
			'name' => $name,
			'image' => $image,
			'profile' => $profile,
		];
		$sql = 'INSERT into users (id, screen_id, name, image, profile) values (:id, :screen_id, :name, :image, :profile)';
		$pstmt = $pdo->prepare($sql);
		$result = $pstmt->execute($data);
		
		$pstmt = null;
		$pdo = null;
		
		return $result;
	}
}