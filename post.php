
<?php include_once("user.php") ?>

<?php //HTML Code ?>
<?php 
	$uid=validation();
	if(validation())
		$user = new User( $uid );
	else
		die("");
	$out = $user->getPost();
	
	$output = $out['output'];
	$meta = $out['meta'];
	

?>

<div id="showUsername">Hello! <?php echo $user->getName() ?> <a href="http://140.114.75.11:8080/ITRI/login.php?logout=1">登出</a></div>
<div id='article_title'><?php echo "Title:<font color='red'>".$meta['title']."</font>" ?></div><br />

<div id = 'count' >本篇尚有<input type="text" id='total' size=3 value=<?php echo $meta['count'];?>>筆資料需要標註<img id="loadingPic" width=16 height=16 src = 'img/loading.gif' /></div>
<div id="help">
	<img  src = 'img/positive.png' /> Product
	<img  src = 'img/cpositive.png' /> Comment
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
				<td class='text'><p><?php echo $value ?></p></td>
				<td class='tag'>
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
