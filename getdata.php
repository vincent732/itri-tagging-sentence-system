
<?php 
try {
    $db = new PDO('sqlite:Mobile.db');
} catch (Exception $e) {
    die ($e);
}

// Get posts from database
try {
    $posts = $db->prepare("SELECT pid,cid,content FROM PDA_HTC_Comments where pid = (select pid from PDA_HTC_POST where tagged == '0' order by pid limit 1)");
    $posts->execute();
} catch (Exception $e) {
    die ($e);
}
$output = array();
$pid = '';
while($row = $posts->fetch(PDO::FETCH_ASSOC) ) {
	if($pid == '')
	  $pid = $row['pid'];
	$output[$row['cid']] = $row['content'];
}
$output['count'] = count($output);

//Get title from DB
try {
    $posts = $db->prepare("select title from PDA_HTC_POST where pid ='".$pid."'");
    $posts->execute();
} catch (Exception $e) {
    die ($e);
}
while($row = $posts->fetch(PDO::FETCH_ASSOC) ) {
	$output['title'] = $row['title'];
}
echo json_encode($output);
?>