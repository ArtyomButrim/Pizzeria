<?php
require_once 'vendor/autoload.php';
require_once 'DataBase/dataBase.php';

	if (isset($_SESSION['id'])) {
		unset($_SESSION['id']);
	}

	header("Location: index.php");