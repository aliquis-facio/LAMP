<?php
include_once("./error_report");
include_once("./sql_connect.php");

// get paremeters
$id = $_POST["id"];
$pw = hash('sha512', $_POST["pw"]);
$email = $_POST["email"];
$name = $_POST["name"];
$birth = $_POST["birth"];
echo $birth;
$number = $_POST["number"];

// id overlap check
$select_sql = "SELECT * FROM member WHERE id = ?";
$stmt = $conn->prepare($select_sql);
$stmt->bind_param('s', $id);
$stmt->execute();
$ret = $stmt->get_result();
$cnt = $ret->num_rows;
$stmt->reset();

if ($cnt == 1) {
    echo "<script>
    alert('이미 존재하는 아이디입니다!');
    history.back();
    </script>";
    exit;
} else {
    // new register
    $insert_sql = "INSERT INTO `member` VALUES (:id, :pw, :name, :birth, :number, :email)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param(':id', $id);
    $stmt->bind_param(':pw', $pw);
    $stmt->bind_param(':name', $name);
    $stmt->bind_param(':birth', $birth);
    $stmt->bind_param(':number', $number);
    $stmt->bind_param(':email', $email);
    $stmt->execute();
    $error_code = $stmt->errno;
    $stmt->close();
    
    if ($error_code == 0) {
        echo "<script>
        alert('회원가입되셨습니다!');
        location.href = '/layouts/sign-in.php';
        </script>";
        exit;
    } else {
        echo "<script>
        alert('잘못 입력하셨습니다!');
        history.back();
        </script>";
    }
}
?>