
<?php include('user.php') ?>
<?php include('setting.php') ?>
<?php 

	/*
	Back-End user interface
	
	Author: Neo
	Update: 2012/07/24
	
	*/

	

$uid=validation();
if(validation())
	$user = new User( $uid );
else
	die("");

if( array_key_exists("showUser", $_GET ) ){
	$allUser = $user->getAllUser();
	echo "<table border=1>";
	foreach($allUser as $uarr){
		echo "<tr>";
		foreach($uarr as $k=>$v){
			echo "<td>".$v."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}
else{

	try {
		$pdo = new PDO('sqlite:Mobile.db');
	} catch (Exception $e) {
		die ($e);
	}
	// SELECT pid,cid,content FROM PDA_HTC_Comments
	$cur = $pdo->prepare("SELECT B.content, A.Type, A.Annotation , A.UID FROM Comment_Note A, PDA_HTC_Comments B WHERE B.cid=A.CommentSn ORDER BY B.cid;");
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
			
			if($k=="Annotation")
				echo $SentiDic[$v];
			else if($k=="Type")
				echo $TypeDic[$v];
			else
				echo $v;
			echo "</td>";
		}
		echo "</tr>";
		
	}
	echo "</table>";
}






?>