<?php
$conn = mysqli_connect('localhost', 'u625594111_root', '1q3rdps9', 'u625594111_mydb');
$query = "SELECT * FROM new_winners";
$stack = array();
$req = mysqli_query($conn, $query);
$i=0;
while($res = mysqli_fetch_assoc($req) and $i < 5){
    array_push($stack, $res);
    $i += 1;
}
mysqli_free_result($req);

foreach ($stack as $key => $value) {
    mysqli_free_result($req);
    $req = mysqli_query($conn, "DELETE FROM new_winners WHERE id=".$value['id']);
    mysqli_free_result($req);
	$req = mysqli_query($conn, "INSERT INTO winners (name, photo, surprise) VALUES ('".$value['name']."','".$value['photo']."', '".$value['surprise']."')");
}

mysqli_close($conn);
?>