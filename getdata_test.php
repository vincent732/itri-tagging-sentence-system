
<?php 
try {
    $db = new PDO('sqlite:Mobile.db');
} catch (Exception $e) {
    die ($e);
}

// Get posts from database
try {
    $posts = $db->prepare("SELECT * FROM PDA_HTC_Comments where pid = (select pid from PDA_HTC_POST where tagged == '0' order by pid limit 1)");
    $posts->execute();
} catch (Exception $e) {
    die ($e);
}
$output = array();
$pid = '';
while($row = $posts->fetch(PDO::FETCH_ASSOC) ) {
	if($pid == '')
	  $pid = $row['pid'];
    echo "<pre>";
    echo print_r($row);
    echo "</pre>";
	
}

?>