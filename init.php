
<?php 

	/*
	
	Warning!! Execute this program would delete the follwing database!!
	
	Initialize all databases including: 
		User.db  ---------- User login data and user log
		Annotation.db ----- Annotation log
		Mobile.db --------- Create a table for annotation sync (The data won't be changed)
	
	Author: Neo
	Update: 2012/07/18
	
	*/
	
	// Create annotation database
	try {
		$db = new PDO('sqlite:Annotation.db');
	} catch (Exception $e) {
		die ($e);
	}
	
    try {
        $db->exec("CREATE TABLE IF NOT EXISTS Comment_Note ( CommentSn , Type , Annotation , UID )");
		
        $db->exec("CREATE TABLE IF NOT EXISTS Post_Note ( PostSn , Annotation , UID )");
    
    } catch (Exception $e) {
		die ($e);
    }
	
	// Create user database
	try {
		$db_user = new PDO('sqlite:User.db');
	} catch (Exception $e) {
		die ($e);
	}
	
    try {
        $db_user->exec("CREATE TABLE IF NOT EXISTS User ( UID INTEGER PRIMARY KEY AUTOINCREMENT, Username , Passwd , Email );");
		

		
		// Create test user 
		$db_user->exec("INSERT INTO User ( UID , Username , Passwd , Email ) VALUES ( 1 , 'neo' , 'handsomeneo' , 'koromiko1104@gmail.com' )");

        $db_user->exec("CREATE TABLE IF NOT EXISTS UserLog ( UID , PostSn , time )");
        
		
		
    } catch (Exception $e) {
		die ($e);
    }
	
	
	// Create sync-state database
	
	try {
		$db_mobile = new PDO('sqlite:Mobile.db');
	} catch (Exception $e) {
		die ($e);
	}
	
	$db_mobile->exec("DROP TABLE Comment_Note");
	$db_mobile->exec("DROP TABLE Post_Note");
	
	$db_mobile->exec("CREATE TABLE IF NOT EXISTS Comment_Note ( CommentSn Integer , Type , Annotation , UID )");
		
    $db_mobile->exec("CREATE TABLE IF NOT EXISTS Post_Note ( PostSn Integer , Annotation , UID )");

	$db_mobile->exec("UPDATE UserState SET State=0 AND UID=0");
	$cur = $db_mobile->prepare("SELECT * FROM UserState LIMIT 10");
	$cur->execute();
	print_r( $cur->fetchAll() );
	
	
	// State{ 0:New, 1:Processing, 2:Done }
	// $db_mobile->exec("DROP TABLE UserState");
	// $db_mobile->exec("CREATE TABLE IF NOT EXISTS UserState ( CommentSn , PostSn , UID , State )");
	
	
	// $res = $db_mobile->prepare("SELECT pid, cid FROM PDA_HTC_Comments");
	// $res->execute();
	// while($row = $res->fetch(PDO::FETCH_ASSOC) ) {
		
		// $cur = $db_mobile->prepare("INSERT INTO UserState ( CommentSn , PostSn , UID , State ) VALUES( ? , ? , 0 , 0 )");
		// $cur->bindParam(1, $row['cid'], PDO::PARAM_INT);
		// $cur->bindParam(2, $row['pid'], PDO::PARAM_INT);
		// $cur->execute();
		
	// }
	// $cur = $db_mobile->prepare("SELECT * FROM UserState LIMIT 10");
	// $cur->execute();
	// print_r( $cur->fetch() );

?>