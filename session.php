<?php
	session_start();
	$action = $_GET['action'];
	switch ($action) {
    case 'set':
		$email = $_GET['email'];
		$_SESSION['email'] = $email;
		echo 'ok';
        break;
    case 'check':
		if(isset($_SESSION['email'])){
			echo $_SESSION['email'];
		}else
			echo false;
        break;
    case 'delete':
		unset($_SESSION['email']);
		echo 'ok';
        break;
	}
?>