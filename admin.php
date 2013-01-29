<?php include('user.php') ?>
<?php include('setting.php') ?>
<?php ini_set('memory_limit', '-1');?>
<html>
<head>
	<link REL="SHORTCUT ICON" HREF="./img/NAS.ico" />
	
	<!-- Charset -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<!-- No Cache -->
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<title>Admin Page</title>
	<!-- css -->
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<!-- javascript -->
	<script type="text/javascript" src="js/jquery-latest.js"></script>
	
	<script type="text/javascript" src="js/main.js"></script>

</head>
<body class="body">
	<div class="container" style='max-height:600px;overflow: auto;'>
		<!--- title -->
		<div class = 'title'>
			<div class="sub-title">Admin Page</div>
		</div>
<?php 

	/*
	Back-End user interface
	
	Author: Neo
	Update: 2012/07/24
	
	*/

	

$uid=validation();
if(validation()){
	$user = new User( $uid );
	echo '<div class = "banner">Log in as <b>'.$user->getName().'</b></div></br></br>';
	echo '<a style="float:left;color:black;" href="index.php">&nbsp&nbsp&nbsp&nbsp&nbsp回到首頁</a></br>';
}
else{
	echo 'Please <a href="index.php">Sign in</a> to continue!';
	die("");
}
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
		$pdo = new PDO('sqlite:Baby.seg.db');
	} catch (Exception $e) {
		die ($e);
	}
	// SELECT pid,cid,content FROM PDA_HTC_Comments
	$cur = $pdo->prepare("SELECT B.content, A.Type, A.Annotation , A.UID FROM Comment_Note A, PDA_HTC_Comments_New B WHERE B.cid=A.CommentSn ORDER BY A.UID;");
	// $cur = $pdo->prepare("SELECT A.CommentSn, A.Type, A.Annotation  FROM Comment_Note A WHERE A.CommentSn = 35008265;");
	/*
	try {
		$cur->execute();
	} catch (Exception $e) {
		die ($e);
	}
	$row = $cur->fetchAll(PDO::FETCH_ASSOC);
	echo "<table style='float:left'>";
	echo "<th>Content</th><th>Type</th><th>Annotation</th><th>UserID</th>";
	
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
	*/
}

?>
	</div>
	<div class = "banner">Summary. <br>
	<?php
		//Fetch all User name
		try {
			$pdo = new PDO('sqlite:User.db');
		} catch (Exception $e) {
			die ($e);
		}
		$cur = $pdo->prepare("Select UID,Username from User");
		try {
			$cur->execute();
		} catch (Exception $e) {
			die ($e);
		}
		$user = $cur->fetchAll(PDO::FETCH_ASSOC);
		
		//Comment Count
		try {
			$pdo = new PDO('sqlite:Baby.seg.db');
		} catch (Exception $e) {
			die ($e);
		}
		$array = array("vincent" => 3608, "wujc" => 26288,"a600tw" => 4584, 'teer'=>5717, 'nishin'=>31100,'ginav'=>21792, 'maxis'=>70,'mavis'=>0, 'grass'=>0, 'ikulan'=>0, 'nlplab'=>0,'neo'=>0);
		foreach( $user as $b){
			$cur = $pdo->prepare("Select distinct CommentSn as count from Comment_Note where UID = ?");
			$cur->bindParam(1, $b['UID'], PDO::PARAM_INT);
			try {
				$cur->execute();
			} catch (Exception $e) {
				die ($e);
			}
			$total = $cur->fetchAll(PDO::FETCH_ASSOC);
			$now_count =  count($total) - $array[$b['Username']];
			echo "<div style='float:left;'>".$b['Username'].':'.$now_count.'</div><br>';
		}
	?>
	<!---Bottom -->
	</div>
		<div class="bot">
			<!--<div>
				<a href = 'http://nlp.cs.nthu.edu.tw/' target='_blank'>NTHU NLP Lab</a>&
				<a href = 'http://www.itri.org.tw/chi/icl/' target='_blank'>ITRI</a>
			</div>-->
			
		</div>
</body>
<html>