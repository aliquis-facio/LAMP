<?php
include_once("./user_session.php");
include_once("./sql_connect.php");

// Get User's DB Data Using Prepare Statement
$select_sql = "SELECT * FROM `member` WHERE id=?";
$stmt = $conn->prepare($select_sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$ret = $stmt->get_result();
$row = $ret->fetch_assoc();

$id = $row['id'];
$curr_pw = $row['pw'];
$curr_name = $row['name'];
$curr_birth = $row['birth'];
$curr_email = $row['email'];
$curr_number = $row['number'];

// Get User's Input Data
$new_name = $_POST['new_name'] == "" ? $curr_name : $_POST['new_name'];
$new_number = $_POST['new_number'] == "" ? $curr_number : $_POST['new_number'];
$new_email = $_POST['new_email'] == "" ? $curr_email : $_POST['new_email'];
$new_birth = $_POST['new_birth'] == "" ? $curr_birth : $_POST['new_birth'];
$input_curr_pw = hash('sha512', $_POST['input_curr_pw']);
$new_pw = $_POST['new_pw'] == "" ? $curr_pw : hash('sha512', $_POST['new_pw']);

$stmt->reset();
if ($input_curr_pw == $curr_pw) {
    // Update User's Data
    $update_sql = "UPDATE `member` SET `name`=?,`birth`=?,`number`=?,`email`=?,`pw`=? WHERE `id`=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('ssssss', $new_name, $new_birth, $new_number, $new_email, $new_pw, $id);
    $ret = $stmt->execute();

    if ($ret) echo "<script>
    alert('개인정보 변경이 완료되었습니다!');
    location.href = '../mypage.php';
    </script>";
    $stmt->close();
} else {
    echo "<script>
    alert('비밀번호를 잘못 입력하셨습니다!');
    history.back();
    </script>";
}
?>