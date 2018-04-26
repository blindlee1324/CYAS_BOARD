<?php

namespace App;

use \PDO;

class Connection extends PDO {
	private $host = 'localhost';
	private $dbname = 'twitcasting_board';
	private $user = 'tcboard';
	private $password = 'y1d3k2r4';
	private $options = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
	
	function __construct($database = 'DefaultDatabase') {
        parent::__construct("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->password, $this->options);
	}
}