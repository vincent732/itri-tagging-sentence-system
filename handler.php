
<?php include('user.php') ?>
<?php include('setting.php') ?>
<?php 

	/*
	Basic data operation program including: save, load, and user log
	
	Author: Neo
	Update: 2012/07/18
	
	*/

	

$uid=validation();
if(validation())
	$user = new User( $uid );
else
	die("");

// Get posts from database
if($_GET['method']=="insert"){
	try {
		$sent_sn = $_GET['CommentSn'];
		$type = $_GET['Type'];
		$anno = $_GET['Annotation'];
    } catch (Exception $e) {
        die ($e);
    }
	
	$user->add_annotation( $sent_sn , $type , $anno );
	echo 1;

}else if($_GET['method']=="showData"){
	print_all();
}
else if($_GET['method']=="markAsDone"){
	$sn = $_GET['CommentSn'];
	$user->mark_as_done( $sn );
	echo 1;
}
else if($_GET['method']=="addUser"){
	try {
		$db_user = new PDO('sqlite:User.db');
	} catch (Exception $e) {
		die ($e);
	}
	$uname = $_GET['uname'];
	$passwd = $_GET['passwd'];
	$email = $_GET['email'];

	$cur = $db_user->prepare("REPLACE INTO User ( Username , Passwd , Email ) VALUES ( ? , ? , ? )");
	$cur->bindParam(1, $uname);
	$cur->bindParam(2, $passwd);
	$cur->bindParam(3, $email);
	try {
		$cur->execute();
	} catch (Exception $e) {
		die ($e);
	}
	header("Location:adduser.php?msg=User ".$uname." added!");
	exit;

}

// ====================================== Funtion ==========================================

// Print error message
function error_msg( $msg ){
	print_r($msg);
	return 0;
}

// For debug
function print_all(){
    try {
        $pdo = new PDO('sqlite:Mobile.db');
    } catch (Exception $e) {
        die ($e);
    }
	// SELECT pid,cid,content FROM PDA_HTC_Comments
	$cur = $pdo->prepare("SELECT B.content, A.Type, A.Annotation , A.UID FROM Comment_Note A, PDA_HTC_Comments B WHERE B.cid=A.CommentSn;");
	// $cur = $pdo->prepare("SELECT A.CommentSn, A.Type, A.Annotation  FROM Comment_Note A WHERE A.CommentSn = 35008265;");

	try {
		$cur->execute();
	} catch (Exception $e) {
		die ($e);
	}
	$row = $cur->fetchAll(PDO::FETCH_ASSOC);
	echo "<table>";
	echo "<th>Comment Sn</th><th>Type</th><th>Annotation</th><th>UserID</th>";
    foreach( $row as $b){
		echo "<tr>";
		foreach( $b as $k=>$v){
			echo "<td>";
			echo $k;
			echo "<br />";
			echo $v;
			echo "<br />";
		}
		echo "</tr>";
		
	}
	echo "</table>";
	
	
	$cur = $pdo->prepare("SELECT * FROM UserState WHERE State=1");

	try {
		$cur->execute();
	} catch (Exception $e) {
		die ($e);
	}
	$row = $cur->fetchAll(PDO::FETCH_ASSOC);
	echo "<table>";
	echo "<th>Comment Sn</th><th>Type</th><th>Annotation</th><th>UserID</th>";
    foreach( $row as $b){
		echo "<tr>";
		foreach( $b as $k=>$v){
			echo "<td>";
			echo $k;
			echo "<br />";
			echo $v;
			echo "<br />";
		}
		echo "</tr>";
		
	}
	echo "</table>";
}




?>