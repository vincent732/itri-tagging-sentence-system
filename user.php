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
			$this->__db_mobile = new PDO('sqlite:Baby.seg.db');
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
		
		//先判斷是否已經存在，先刪除後再insert
		/*$cSn = $this->__db_mobile->prepare('select CommentSn,Type From Comment_Note where CommentSn = ?');
		$cSn->bindParam(1, $commentsn, PDO::PARAM_INT);
		try{
			$cSn->execute();
		}catch (Exception $e) {
			die ($e);
		}
		$coSn = $cSn->fetch(PDO::FETCH_ASSOC);
		$commSn = $coSn['CommentSn'];
		$commType = $coSn['Type'];
		if($commSn == $commentsn and $type == $commType){//已經存在
			$cur = $this->__db_mobile->prepare('Delete From Comment_Note where CommentSn = ? and Type=?');
			$cur->bindParam(1, $commentsn, PDO::PARAM_INT);
			$cur->bindParam(2, $commType, PDO::PARAM_INT);
			try{
				$cur->execute();
			}catch (Exception $e) {
				die ($e);
			}
		}
		//開始insert
		*/
		$cur = $this->__db_mobile->prepare("REPLACE INTO Comment_Note ( CommentSn , Type , Annotation , UID, date ) VALUES ( ? , ? , ? , ?, ?)");
		$cur->bindParam(1, $commentsn, PDO::PARAM_INT);
		$cur->bindParam(2, $type, PDO::PARAM_INT);
		$cur->bindParam(3, $anno, PDO::PARAM_INT);
		$cur->bindParam(4, $this->__uid, PDO::PARAM_INT);
		$cur->bindParam(5, date("Y-m-d H:i:s") );
		
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
			//判斷是否有上次尚未標記完的post
			$posts = $this->__db_mobile->prepare("SELECT PostSn FROM UserState WHERE State=1 AND UID=? GROUP BY PostSn LIMIT 1");			
			$posts->bindParam( 1, $this->__uid , PDO::PARAM_INT );
			$posts->execute();
			$postSn = $posts->fetch(PDO::FETCH_ASSOC);
			
			$postSn = $postSn['PostSn'];
			// echo $postSn;
			
			if($postSn==""){
				//如果沒有，取出新的Post
				$posts = $this->__db_mobile->prepare("SELECT PostSn FROM UserState WHERE State=0 LIMIT 1");
				$posts->execute();
				
				$postSn = $posts->fetch(PDO::FETCH_ASSOC);
				$postSn = $postSn['PostSn'];
				
				// Mark as processing
				$this->mark_as_processing($postSn);
			}
			
			// $posts = $db->prepare("SELECT PDA_HTC_Comments.pid,PDA_HTC_Comments.cid,PDA_HTC_Comments.content FROM PDA_HTC_Comments, UserState where PDA_HTC_Comments.cid = UserState.CommentSn and UserState.State==0 and UserState.PostSn = ?");
			// $posts = $this->__db_mobile->prepare("SELECT A.pid,A.cid,A.content FROM PDA_HTC_Comments A, UserState B WHERE A.pid = ? AND B.State!=2");
			$posts = $this->__db_mobile->prepare("SELECT A.pid,A.cid,A.content FROM PDA_HTC_Comments_New A, UserState B WHERE A.cid= B.CommentSn AND B.postSn = ? AND B.State!=2;");
			
			$posts->bindParam( 1, $postSn , PDO::PARAM_STR );
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
			if($row!=''){
				$meta['title'] = $row['title'];
			}else{
				$meta['title'] = '';
			}
		}
		$bindOutput['meta'] = $meta;
		$bindOutput['output'] = $output;
		$bindOutput['debug'] = $postSn;
		$bindOutput['sql'] = "SELECT A.pid,A.cid,A.content FROM PDA_HTC_Comments_New A, UserState B WHERE A.cid=B.CommentSn AND B.postSn=".$postSn." AND B.State!=2;";
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