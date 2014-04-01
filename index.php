
<?php include("user.php") ?>

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
		<!--- title -->
		<div class = 'title'>
			<div class="sub-title"><a href='index.php'>口碑標記</a></div>
		</div>
		<div id="page" style = "display:block">
				<?php 
				if( validation()!=0 )
					include("post.php"); 
				else{
				?>
				
				<div class="login_page">
					<div class='top_label'>Sign in</div><br>
					<form id="login_form">
						<div class='label'>account</div><br>
						<input class='area' type='text' id="username" name='username' /><br><br>
						<div class='label'>password </div><br>
						<input class='area' type='password' id="passwd" name='passwd' /><br><br>
						<input id="submit_btn" class='submit' type='button' value="Login" onClick="showLoading()" />
						
						<div style='padding-left:5px;text-align:center;' class='label'><a href='adduser.php'>Create a new account</a></div>
						<img id="loadingPic" style='display:none' width=16 height=16 src = 'img/loading.gif' />
					</form>
				</div>
				<?php }?>
		</div>
		<!---Bottom -->
		
		<div class="bot">
			<!--<div>
				<a href = 'http://nlp.cs.nthu.edu.tw/' target='_blank'>NTHU NLP Lab</a>&
				<a href = 'http://www.itri.org.tw/chi/icl/' target='_blank'>ITRI</a>
			</div>
			<br>-->
				建議使用IE9、Firefox或Chrome等瀏覽器瀏覽.
		</div>
		
	</div>

	
</body>
</html>
