<?php

namespace Model;

use \PDO;

class Connection extends PDO {
	private $host = '<YOUR-HOST-NAME>';
	private $dbname = '<YOUR-DB-NAME>';
	private $user = '<YOUR-USER-NAME>';
	private $password = '<YOUR-DB-PASSWORD>';
	private $options = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
	
	function __construct($database = 'DefaultDatabase') {
        parent::__construct("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->password, $this->options);
	}
}