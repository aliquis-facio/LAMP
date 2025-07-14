<?php
include_once("./user_session.php");
include_once("./sql_connect.php");

$input_pw = hash('sha512', $_POST['pw']);
$user_id = $_SESSION['user_id'];

// Check input_pw and pw are same
$select_sql = $select_sql = "SELECT id, pw FROM member WHERE id = ?";
$stmt = $conn->prepare($select_sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$ret = $stmt->get_result();
$row = $ret->fetch_assoc();
$pw = $row['pw'];
$stmt->reset();

if ($pw != $input_pw) {
    echo "<script>
    alert('비밀번호를 다시 입력해주세요');
    history.back();
    </script>";
    exit;
}

// Delete account
$delete_sql = "DELETE FROM `member` WHERE `id`=?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();

echo "<script>
alert('삭제되었습니다');
location.replace('/layouts/sign-in.php');
</script>";

$stmt->close();
?>