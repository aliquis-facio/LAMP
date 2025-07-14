<?php
include_once("./sql_connect.php");

if(!session_id()) {
    session_start();
}

// prepare statement 준비
$select_sql = "SELECT * FROM member WHERE id = ?";
$stmt = $conn->prepare($select_sql);
$stmt->bind_param('s', $id);

// get parameters
$id = $_POST["id"];
$pw = hash('sha512', $_POST["pw"]);

$stmt->execute();
$ret = ($stmt->get_result())->fetch_assoc();

if ($ret['pw'] == $pw) {
    $_SESSION['user_id'] = $ret['id'];
    $_SESSION['user_name'] = $ret['name'];
    $_SESSION['user_score'] = $ret['score'];
    echo "<script>location.replace('../layouts/index.php');</script>";
} else {
    echo "<script>alert('아이디(로그인 전화번호, 로그인 전용 아이디) 또는 비밀번호가 잘못 되었습니다. 아이디와 비밀번호를 정확히 입력해 주세요.')</script>";
    echo "<script>location.replace('../layouts/sign-in.php');</script>";
    exit;
}

$stmt->close();
?>