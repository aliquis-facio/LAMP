<?php
include_once("./error_report.php");
include_once("./sql_connect.php"); // $conn은 PDO 객체

// password_hash(string $password, string|int|null $algo, array $options = []): string

// 입력값 수집
$id = $_POST["id"] ?? '';
$pw = hash('sha512', $_POST["pw"] ?? '');
$email = $_POST["email"] ?? '';
$name = $_POST["name"] ?? '';
$birth = $_POST["birth"] ?? '';
$number = $_POST["number"] ?? '';

// 유효성 검사
if (!$id || !$pw || !$email || !$name || !$birth || !$number) {
    echo "<script>alert('모든 항목을 입력해주세요.'); history.back();</script>";
    exit;
}

try {
    // 아이디 중복 체크
    $select_sql = "SELECT id FROM member WHERE id = :id";
    $stmt = $conn->prepare($select_sql);
    $stmt->execute([':id' => $id]);
    $cnt = $stmt->rowCount();

    if ($cnt > 0) {
        echo "<script>
            alert('이미 존재하는 아이디입니다!');
            history.back();
        </script>";
        exit;
    }

    // 신규 회원가입
    $insert_sql = "INSERT INTO member (id, pw, name, birth, number, email)
                   VALUES (:id, :pw, :name, :birth, :number, :email)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->execute([
        ':id' => $id,
        ':pw' => $pw,
        ':name' => $name,
        ':birth' => $birth,
        ':number' => $number,
        ':email' => $email
    ]);

    echo "<script>
        alert('회원가입 되셨습니다!');
        location.href = '/layouts/sign-in.php';
    </script>";
    exit;

} catch (PDOException $e) {
    echo "<script>
        alert('회원가입 중 오류가 발생했습니다!');
        history.back();
    </script>";
    // 개발 중일 경우: error_log($e->getMessage());
    exit;
}
?>
