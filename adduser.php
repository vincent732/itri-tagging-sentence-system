
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
	<title>產品屬性標記</title>
	<!-- css -->
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<!-- javascript -->
	<script type="text/javascript" src="js/jquery-latest.js"></script>
	
	<script type="text/javascript" src="js/main.js"></script>

</head>
<body class="body">
	<h1>新增使用者</h1>
	<?php if( array_key_exists( "msg" , $_GET ) ){ echo $_GET['msg']; }?>
	<br />
	<form name="adduser_form" action="handler.php" method="GET" >
	Username: <input name="uname" type="text" size=40 />
	Password: <input name="passwd" type="password" size=40 />
	email: <input name="email" type="text" size=40 />
	<input name="method" type="hidden" value="addUser" />
	<input type="submit" value="送出" />
	</form>
	
</body>
</html>