<?php session_start(); ?>
<?php 
	/*
	Basic user operation program including: user login, user log
	
	Author: Neo
	Update: 2012/07/18
	
	*/
	
// Basic user class
class User{
	private $__uid;
	private $__PostSn;
	private $__db_mobile;
	private $__db_user;
	private $__db_annotation;
	
	
	public function __construct( $u ){
		$this->__uid = $u;
		
		try {
			$this->__db_mobile = new PDO('sqlite:Mobile.db');
		} catch (Exception $e) {
			die ($e);
		}
		try {
			$this->__db_user = new PDO('sqlite:User.db');
		} catch (Exception $e) {
			die ($e);
		}
		
		try {
			$this->__db_annotation = new PDO('sqlite:Annotation.db');
		} catch (Exception $e) {
			die ($e);
		}
	}

	private function __UserLog(){
	}
	
	private function __setDB(){

	}
	

	public function getAllUser(){
		$cur = $this->__db_user->prepare("SELECT * FROM User ORDER BY UID");
		$cur->execute();
		$res = $cur->fetchAll(PDO::FETCH_ASSOC);

		return $res;
	}

	public function mark_as_done( $sn ){
		$cur = $this->__db_mobile->prepare("UPDATE UserState SET State=2 WHERE CommentSn == ?");
		$cur->bindParam(1, $sn, PDO::PARAM_INT);
		try {
			$cur->execute();
		} catch (Exception $e) {
			die ($e);
		}
		return 1;
	}
	
	private function mark_as_processing( $postsn ){
		$cur = $this->__db_mobile->prepare("UPDATE UserState SET State=1, UID=? WHERE PostSn == ?");
		$cur->bindParam(1, $this->__uid, PDO::PARAM_INT);
		$cur->bindParam(2, $postsn, PDO::PARAM_INT);
		try {
			$cur->execute();
		} catch (Exception $e) {
			die ($e);
		}
		return 1;
	}
	
	public function add_annotation( $commentsn , $type , $anno ){
		
		$cur = $this->__db_mobile->prepare("REPLACE INTO Comment_Note ( CommentSn , Type , Annotation , UID ) VALUES ( ? , ? , ? , ? )");
		$cur->bindParam(1, $commentsn, PDO::PARAM_INT);
		$cur->bindParam(2, $type, PDO::PARAM_INT);
		$cur->bindParam(3, $anno, PDO::PARAM_INT);
		$cur->bindParam(4, $this->__uid, PDO::PARAM_INT);
		// $cur->bindParam(5, date("Y-m-d H:i:s") );
		
		try {
			$cur->execute();
		} catch (Exception $e) {
			die ($e);
		}
		
		
		
		return 1;
	}


	
	public function getPost(){


		// Get posts from database
		try {
			$posts = $this->__db_mobile->prepare("SELECT PostSn FROM UserState WHERE State=1 AND UID=? GROUP BY PostSn LIMIT 1");			
			$posts->bindParam( 1, $this->__uid , PDO::PARAM_INT );
			$posts->execute();
			$postSn = $posts->fetch(PDO::FETCH_ASSOC);
			
			$postSn = $postSn['PostSn'];
			// echo $postSn;
			
			if($postSn==""){
				$posts = $this->__db_mobile->prepare("SELECT PostSn FROM UserState WHERE State=0 LIMIT 1");
				$posts->execute();
				
				$postSn = $posts->fetch(PDO::FETCH_ASSOC);
				$postSn = $postSn['PostSn'];
				
				// Mark as processing
				$this->mark_as_processing($postSn);
			}
			
			// $posts = $db->prepare("SELECT PDA_HTC_Comments.pid,PDA_HTC_Comments.cid,PDA_HTC_Comments.content FROM PDA_HTC_Comments, UserState where PDA_HTC_Comments.cid = UserState.CommentSn and UserState.State==0 and UserState.PostSn = ?");
			// $posts = $this->__db_mobile->prepare("SELECT A.pid,A.cid,A.content FROM PDA_HTC_Comments A, UserState B WHERE A.pid = ? AND B.State!=2");
			$posts = $this->__db_mobile->prepare("SELECT A.pid,A.cid,A.content FROM PDA_HTC_Comments_new A, UserState B WHERE A.cid=B.CommentSn AND B.postSn=? AND B.State!=2;");
			
			$posts->bindParam( 1, $postSn , PDO::PARAM_INT );
			$posts->execute();
		} catch (Exception $e) {
			die ($e);
		}
		
		$output = array();
		$meta = array();
		$bindOutput = array();
		$pid = '';
		while($row = $posts->fetch(PDO::FETCH_ASSOC) ) {
			
			if($pid == '')
			  $pid = $row['pid'];
			$output[$row['cid']] = $row['content'];
		}
		$meta['count'] = count($output);
		
		//Get title from DB
		try {
			$posts = $this->__db_mobile->prepare("SELECT title from PDA_HTC_POST WHERE pid ='".$postSn."'");
			$posts->execute();
		} catch (Exception $e) {
			die ($e);
		}
		while($row = $posts->fetch(PDO::FETCH_ASSOC) ) {
			$meta['title'] = $row['title'];
		}
		$bindOutput['meta'] = $meta;
		$bindOutput['output'] = $output;
		$bindOutput['debug'] = $postSn;
		return $bindOutput;
	}
	
	
	public function get_uid(){

		$cur = $this->__db_user->prepare("SELECT UID FROM User WHERE Username = ?");
		$cur->bindParam( 1, $username );
		$cur->execute();
		$res = $cur->fetchAll();

		return $res[0];
	}
	

	public function getName(){

		$cur = $this->__db_user->prepare("SELECT Username FROM User WHERE UID = ?");
		
		
		$cur->bindParam( 1 , $this->__uid );
		$cur->execute();
		$res = $cur->fetch();

		return $res['Username'];
	}
	
	

	
	
}	
	

function validation(){	
	$uid = 0;
	if( array_key_exists( 'uid' , $_SESSION ) ){
		$uid = $_SESSION['uid'];
	}
	return $uid;
}	

?>