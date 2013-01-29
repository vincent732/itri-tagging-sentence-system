
<?php 
	/*
	Add user interface
	
	Author: Neo
	Update: 2012/07/18
	
	*/





?>

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
	<title>口碑標記</title>
	<!-- css -->
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<!-- javascript -->
	<script type="text/javascript" src="js/jquery-latest.js"></script>
	
	<script type="text/javascript" src="js/main.js"></script>

</head>
<body class="body">
	<div class="container">
		<div class = 'title'>
				<div class="sub-title"><a href='index.php'>口碑標記</a></div>
				
		</div>
		
		<?php if( array_key_exists( "msg" , $_GET ) ){ echo $_GET['msg']; }?>
		<br />
		<div class='login_page'>
			<form name="adduser_form" action="handler.php" method="GET" >
			<div class='top_label'>Sign up</div><br>
			
			<div class='label'>username</div> 
			<input class='area' name="uname" type="text" size=31 />
			<div class='label'>password</div> 
			<input class='area' name="passwd" type="password" size=31 />
			<div class='label'>email</div> 
			<input class='area' name="email" type="text" size=31 />
			<input name="method" type="hidden" value="addUser" />
			<input class='submit' type="submit" value="Sign up" />
			
			</form>
		</div>
		
		<div class="bot">
			
			<br>
				建議使用Chrome瀏覽器已達最佳瀏覽效果!
		</div>
	</div>
</body>
</html>