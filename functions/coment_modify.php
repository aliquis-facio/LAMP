<?php
include_once("./sql_connect.php");
include_once("./user_session.php");

// Get parameter
date_default_timezone_set('Asia/Seoul');
$created_date = new DateTime("now");
$created_date = $created_date -> format('Y-m-d H:i:s');
$reply = $_POST["reply"];
$coment_id = $_POST["coment_id"];
$post_id = $_POST["post_id"];

// Update reply data to DB using prepare statement
$update_sql = "UPDATE `coment` SET `reply`=?, `created_date`=? WHERE `coment_id` = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param('sss', $reply, $created_date, $coment_id);
$stat = $stmt->execute();

if ($stat) {
    echo "<script>
    alert('수정되었습니다');
    location.replace('../post_view.php?post_id={$post_id}');
    </script>";
} else {
    echo "<script>
    alert('오류가 발생했습니다');
    history.back();
    </script>";
}

$stmt->close();
?>