<?php
include("./user_session.php");
include("./sql_connect.php");

function get_id($conn, $id, $name, $type, $var) {
    $select_sql = "SELECT id, name, {$type}, pw FROM member WHERE id = '{$id}' AND name = '{$name}' AND {$type} = '{$var}'";
    $result = mysqli_fetch_array(mysqli_query($conn, $select_sql));

    if (isset($result['pw'])) {
        echo "<script>alert('당신의 비밀번호는 {$result['pw']}입니다.')</script>";
        echo "<script>location.replace('../index.php');</script>";
    } else {
        echo "<script>alert('아이디 혹은 이름, {$type}을 잘못 입력하셨습니다')</script>";
        echo "<script>location.replace('../find_pw.php');</script>";
        exit;
    }
}

$input_id1 = $_POST['id1'];
$input_name1 = $_POST["name1"];
$input_number = $_POST["number"];
$input_id2 = $_POST['id2'];
$input_name2 = $_POST["name2"];
$input_email = $_POST["email"];

$check1 = empty($input_id1) or empty($input_name1) or empty($input_number);
$check2 = empty($input_id2) or empty($input_name2) or empty($input_email);

if($check1 && $check2) {
    echo "<script>alert('Fill in the blank plz')</script>";
    echo "<script>location.replace('find_pw.php');</script>";
    exit;
} else if($check2) {
    get_id($conn, $input_id1, $input_name1, 'number', $input_number);
} else if($check1) {
    get_id($conn, $input_id2, $input_name2, 'email', $input_email);
}

mysqli_close($conn);
?>