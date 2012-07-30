
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
	<title>產品屬性標記</title>
	<!-- css -->
	<link type="text/css" rel="stylesheet" href="css/main.css" />
	<!-- javascript -->
	<script type="text/javascript" src="js/jquery-latest.js"></script>
	
	<script type="text/javascript" src="js/main.js"></script>

</head>
<body class="body">
	<div id="container">
		<!--- title -->
		<div id = 'title'>
			<div class="sub-title">產品屬性標記</div>
		</div>
		<div id="page" style = "display:block">
				<?php 
				if( validation()!=0 )
					include("post.php"); 
				else{
				?>
				<div id="login_page">
					<form id="login_form">
						帳號: <input type='text' id="username" name='username' />
						密碼: <input type='password' id="passwd" name='passwd' />
						<input id="submit_btn" type='button' value="submit" />
					</form>
				</div>
				<?php }?>
		</div>
		<!---Bottom -->
		<div id="bot">
			<div>
				<a href = 'http://nlp.cs.nthu.edu.tw/' target='_blank'>NTHU NLP Lab</a>&
				<a href = 'http://www.itri.org.tw/chi/icl/' target='_blank'>ITRI</a>
			</div>
		</div>
		
	</div>

	
</body>
</html>