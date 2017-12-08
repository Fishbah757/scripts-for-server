<?php
$conn = mysqli_connect('localhost', 'u625594111_root', '1q3rdps9', 'u625594111_mydb');
$query = "SELECT * FROM all_items";
$stack = array();
$req = mysqli_query($conn, $query);
$i=0;
while($res = mysqli_fetch_assoc($req) and $i < 10){
    array_push($stack, $res);
    $i += 1;
}
mysqli_free_result($req);
$req = mysqli_query($conn, "TRUNCATE TABLE items;");
mysqli_free_result($req);

foreach ($stack as $key => $value) {
    mysqli_free_result($req);
    $req = mysqli_query($conn, "DELETE FROM all_items WHERE id=".$value['id']);
    mysqli_free_result($req);
	$req = mysqli_query($conn, "INSERT INTO items (game, item_name, rare, image) VALUES ('".$value['game']."','".$value['item_name']."', '".$value['rare']."', '".$value['image']."')");
}

mysqli_close($conn);
?>