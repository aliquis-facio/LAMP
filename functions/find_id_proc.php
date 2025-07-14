<?php
include("./user_session.php");
include("./sql_connect.php");

function get_id($conn, $name, $type, $var) {
    $select_sql = "SELECT name, {$type}, id FROM member WHERE name = '{$name}' and {$type} = '{$var}'";
    $result = mysqli_fetch_array(mysqli_query($conn, $select_sql));

    if (isset($result['id'])) {
        echo "<script>alert('당신의 아이디는 {$result['id']}입니다.')</script>";
        echo "<script>location.replace('../index.php');</script>";
    } else {
        echo "<script>alert('이름 혹은 {$type}을 잘못 입력하셨습니다')</script>";
        echo "<script>location.replace('../find_id.php');</script>";
        exit;
    }
}

$input_name1 = $_POST["name1"];
$input_number = $_POST["number"];
$input_name2 = $_POST["name2"];
$input_email = $_POST["email"];

$check1 = empty($input_name1) or empty($input_number);
$check2 = empty($input_name2) or empty($input_email);

if($check1 && $check2) {
    echo "<script>alert('Fill in the blank plz')</script>";
    echo "<script>location.replace('../find_id.php');</script>";
    exit;
} else if($check2) {
    get_id($conn, $input_name1, 'number', $input_number);
} else if($check1) {
    get_id($conn, $input_name2, 'email', $input_email);
}

mysqli_close($conn);
?>