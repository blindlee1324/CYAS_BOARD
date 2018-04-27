<?php

namespace App;

class Post {
	
	// create a new post
	/*
		@param array $user
		@param string title
		@param string content
	*/
	public static function create($user, $title, $content) {
		$pdo = new Connection();
		$data = [
			'title' => $title,
			'content' => $content,
			'user_id' => $user['id'],
			'user_screen_id' => $user['screen_id'],
			'user_name' => $user['name'],
			'user_image' => $user['image'],
			'created' => (new \DateTime())->format('Y-m-d H:i:s')
		];
		$sql = 'INSERT into posts (title, content, user_id, user_screen_id, user_name, user_image, created) values (:title, :content, :user_id, :user_screen_id, :user_name, :user_image, :created)';
		$pstmt = $pdo->prepare($sql);
		$result = $pstmt->execute($data);
		
		$pstmt = null;
		$pdo = null;
		
		return $result;
	}
	
	// delete post with id
	public static function destroy($id) {
		$pdo = new Connection();
	}
	
	// update post with id
	public static function update($id, $title, $content) {
		$pdo = new Connection();
	}
	
	// read a post with id
	public static function read($id) {
		$pdo = new Connection();
		$sql = 'select id, title, content, user_screen_id, user_id, user_name, user_image, hit, created from posts where id='.$id;
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	public static function countAll() {
		$pdo = new Connection();
		$sql = 'select count(*) from posts';
		$result = $pdo->query($sql)->fetchColumn();
		
		return (int)$result;
	}
	
	public static function hit($id) {
		$pdo = new Connection();
		$sql = 'update posts set hit = hit + 1 where id =' . $id;
		$result = $pdo->query($sql);
		
		$result = null;
		$pdo = null;
	}
}