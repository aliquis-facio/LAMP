<?php
include_once("./user_session.php");
include_once("./sql_connect.php");

$post_id = $_GET['post_id'];

$delete_sql = "DELETE FROM `board` WHERE post_id=?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param('s', $post_id);
$stmt->execute();

echo "<script>alert('삭제되었습니다');
location.replace('../index.php');</script>";

$stmt->close();
?>