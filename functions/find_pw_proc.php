<?php
include("./user_session.php");
include("./sql_connect.php"); // $conn은 PDO 객체

// 보안을 위해 비밀번호 직접 노출을 막고, “비밀번호 재설정 페이지 안내” 방식으로 변경하는 것도 추천

function get_pw(PDO $conn, string $id, string $name, string $type, string $var): void {
    if (!in_array($type, ['email', 'number'])) {
        echo "<script>alert('잘못된 요청입니다'); location.replace('../find_pw.php');</script>";
        exit;
    }

    $select_sql = "SELECT pw FROM member WHERE id = :id AND name = :name AND {$type} = :var";
    $stmt = $conn->prepare($select_sql);
    $stmt->execute([
        ':id' => $id,
        ':name' => $name,
        ':var' => $var
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['pw'])) {
        $pw = htmlspecialchars($result['pw'], ENT_QUOTES, 'UTF-8'); // XSS 방지
        echo "<script>alert('당신의 비밀번호는 {$pw} 입니다.');</script>";
        echo "<script>location.replace('../index.php');</script>";
    } else {
        echo "<script>alert('아이디, 이름 또는 {$type}이 일치하지 않습니다');</script>";
        echo "<script>location.replace('../find_pw.php');</script>";
        exit;
    }
}

// 입력값 수집
$input_id1 = $_POST['id1'] ?? '';
$input_name1 = $_POST["name1"] ?? '';
$input_number = $_POST["number"] ?? '';
$input_id2 = $_POST['id2'] ?? '';
$input_name2 = $_POST["name2"] ?? '';
$input_email = $_POST["email"] ?? '';

// 입력값 유효성 검사
$check1 = empty($input_id1) || empty($input_name1) || empty($input_number);
$check2 = empty($input_id2) || empty($input_name2) || empty($input_email);

if ($check1 && $check2) {
    echo "<script>alert('입력칸을 모두 채워주세요');</script>";
    echo "<script>location.replace('../find_pw.php');</script>";
    exit;
} else if ($check2) {
    get_pw($conn, $input_id1, $input_name1, 'number', $input_number);
} else if ($check1) {
    get_pw($conn, $input_id2, $input_name2, 'email', $input_email);
}
?>
