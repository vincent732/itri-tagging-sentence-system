
<?php include_once("user.php") ?>

<?php //HTML Code ?>
<?php 
	$uid=validation();
	echo $uid;
	if(validation())
		$user = new User( $uid );
	else
		die("");
	$out = $user->getPost();
	echo $out;	
	$output = $out['output'];
	$meta = $out['meta'];
	

?>

<div >
	<div style='float:left'>
		
		<div id='article_title'>
			<?php 
			if(isset($out['meta']['title'])){
				echo "Title:<font color='red'>".$meta['title']."</font>"; 
			}else
				echo 'No post available...'; 
			?>
		</div>
		<br><br>
		
		<div id = 'count' >本篇尚有
			<input type="text" id='total' size=3 value=<?php echo $meta['count'];?>>筆資料需要標註<img id="loadingPic" width=16 height=16 src = 'img/loading.gif' />
		</div>
		
	</div>
	<br>
	<div id="help">
		<img  src = 'img/positive.png' /> Product
		<img  src = 'img/cpositive.png' /> Comment
	</div>
</div>


<div id = 'content' >

<table>
<?php
	$i = 0;
	foreach( $output as $key=>$value ){
		if($i % 2 ==0){
			?>
			<tr class = 'odd_col gen_row' id = 'count_<?php echo $i ?>'>
			<?php
		}else{
			?>
			<tr class = 'even_col gen_row' id = 'count_<?php echo $i ?>'>
			<?php
		}
		?>
				<td class='text' style='max-width:816px;'><p><?php echo $value ?></p></td>
				<td class='tag' >
					<div class='Product' pressed=0 >
						<img value=0 CommentSn=<?php echo $key ?> Type=0 title = 'Product: Mark as positive.' onclick = 'updateDB(this)' class = 'mark_btn' src = 'img/positive.png' />
						<img value=1 CommentSn=<?php echo $key ?> Type=0 title = 'Product: Mark as negative.' onclick = 'updateDB(this)' class = 'mark_btn' src = 'img/negative.png' />
						<img value=2 CommentSn=<?php echo $key ?> Type=0 title = 'Product: Mark as neutral.' onclick = 'updateDB(this)' class = 'mark_btn' src = 'img/neutral.png' />
					</div>
					<div class='Comment' pressed=0 >
						<img value=0 CommentSn=<?php echo $key ?> Type=1 title = 'Comment: Mark as positive.' onclick = 'updateDB(this)' class = 'mark_btn' src = 'img/cpositive.png' />
						<img value=1 CommentSn=<?php echo $key ?> Type=1 title = 'Comment: Mark as negative.' onclick = 'updateDB(this)' class = 'mark_btn' src = 'img/cnegative.png' />
						<img value=2 CommentSn=<?php echo $key ?> Type=1 title = 'Comment: Mark as neutral.' onclick = 'updateDB(this)' class = 'mark_btn' src = 'img/cneutral.png' />
					</div>
				</td>
			</tr>
		<?php
		$i+=1;
	}
?>
</table>
</div>
<div id="showUsername" >
	<div>
		Hello! <?php echo $user->getName() ?>&nbsp &nbsp<a class='submit' style='float:right' href="login.php?logout=1">Logout</a><a class='submit' style='float:right' href='admin.php'>Admin</a>
	</div>
</div>
