<?php
include '../inc/connection.php';
$sql = "SELECT * FROM expense WHERE id = " . $_GET["id"];
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_object($result);
echo $row;
header("Content-type: " . $row->type);
echo $row->image;
