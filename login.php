
<?php 
	/*
	Basic login operation program
	
	Author: Neo
	Update: 2012/07/20
	
	*/
	
session_start();
	
if( array_key_exists( 'username' , $_GET ) ){
		try {
			$user_db = new PDO('sqlite:User.db');
		} catch (Exception $e) {
			die ($e);
		}
		$uname = $_GET['username'];
		$passwd = $_GET['passwd'];
		
		$cur = $user_db->prepare("SELECT Passwd, UID FROM User WHERE Username = ?");
		$cur->bindParam( 1 , $uname );
		$cur->execute();
		$res = $cur->fetch();
		
		if( $passwd == $res[0] ){
			$_SESSION['uid'] = $res[1];
			echo json_encode(1);
		}
		else{
			// header('HTTP/1.1 500 Internal Server Error');
			echo json_encode(0);
		}

}


if( array_key_exists( 'logout' , $_GET ) ){
	//unset($_SESSION);
	$_SESSION = array();
	header("Location:index.php");
	exit;
}

if( array_key_exists( 'validation' , $_GET ) ){
	print_r($_SESSION);
}



?>
