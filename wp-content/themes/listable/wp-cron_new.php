<?php
$servername = "localhost";
$username = "captajc8_bnbpoin";
$password = "Dublin@!2016";
$dbname = "captajc8_bnbpoint";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$sql11 = "SELECT meta_value FROM wp_dmfw_postmeta where meta_key = 'image_backgrounds'";
$result11 = mysqli_query($conn, $sql11);
while($row11 = mysqli_fetch_assoc($result11)) {
	$arra = (explode(",",$row11['meta_value']));
	$aa = $row11['meta_value'];
  //print('<pre>'); print_r($arra); print('<pre>');
}
$sql = "SELECT * FROM wp_dmfw_posts where ID IN ($aa)";
$result = mysqli_query($conn, $sql);



if (mysqli_num_rows($result) > 0) {
	
  while($row = mysqli_fetch_assoc($result)) {
      //print('<pre>'); print_r($row); print('<pre>');
		 $myres[] = $row;
    }	
}
$ran = $myres;
$randomElement = array();
$randomElement = $ran[array_rand($ran, 1)];
//print('<pre>'); print_r($randomElement); print('<pre>');
  foreach($myres as $myre){
	  //print('<pre>'); print_r($myre); print('<pre>');
	if($randomElement['ID'] == $myre['ID']){
		$id = $myre['ID'];
	    $sql1 = "UPDATE wp_dmfw_posts SET pinged = 1 WHERE ID = $id";
		mysqli_query($conn, $sql1);
	}
    if($randomElement['ID'] != $myre['ID']){
		  $mid = $myre['ID'];
		  $sql2 = "UPDATE wp_dmfw_posts SET pinged = 0 WHERE ID = $mid";
	      mysqli_query($conn, $sql2);
	} 	
	  
  }

/*if (!in_array($randomElement, $myres)) {
	print('<pre>'); print_r($myres); print('<pre>');
}
$diff_result = array_diff($randomElement,$myres);*/
  
  //print('<pre>'); print_r($diff_result); print('<pre>');

mysqli_close($conn);
?>