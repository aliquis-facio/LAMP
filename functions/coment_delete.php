<?php
include_once("./error_report.php");
include_once("./sql_connect.php");
include_once("./user_session.php");

$coment_id = $_GET['coment_id'];
$post_id = $_GET['post_id'];

$delete_sql = "DELETE FROM `coment` WHERE coment_id=?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param('s', $coment_id);
$stmt->execute();

echo "<script>
alert('삭제되었습니다');
location.replace('../post_view.php?post_id={$post_id}');
</script>";

$stmt->close();
?>