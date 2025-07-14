<?php
include_once("./error_report.php");
include_once("./sql_connect.php");

if (!session_id()) {
    session_start();
}

$user = $_SESSION['user_id'];
$title = $_POST["title"];
$substance = $_POST["substance"];
$post_id = $_POST["post_id"];
date_default_timezone_set('Asia/Seoul');
$modified_date = new DateTime("now");
$modified_date = $modified_date->format('Y-m-d H:i:s');

$update_sql = "UPDATE `board` SET `title`=?,`substance`=?,`created_date`=? WHERE post_id = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param('ssss', $title, $substance, $modified_date, $post_id);
$stmt->execute();

echo "<script>
alert('수정되었습니다');
location.replace('../index.php');
</script>";

$stmt->close();
?>