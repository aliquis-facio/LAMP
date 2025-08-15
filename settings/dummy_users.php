<?php
include_once("../functions/sql_connect.php"); // PDO 연결: $conn (또는 $pdo)
include_once("../functions/error_report.php");

// 생성할 사용자 수
$number_of_users = 50;

// 기본 설정
$base_id = "user";
$default_password = hash('sha512', "password123"); // 모든 유저 동일 비밀번호 (SHA-512)
$base_name = "tester";
$default_birth = "2000-01-01";
$default_number = "010-1234-";
$base_email = "@example.com";

try {
    $conn->beginTransaction();

    for ($i = 1; $i <= $number_of_users; $i++) {
        $uid = $base_id . $i;
        $name = $base_name . $i;
        $number = $default_number . str_pad($i, 4, '0', STR_PAD_LEFT);
        $email = $base_id . $i . $base_email;

        // 중복 확인
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM member WHERE uid = :uid");
        $check_stmt->execute([':uid' => $uid]);
        $exists = $check_stmt->fetchColumn();

        if ($exists == 0) {
            $insert_stmt = $conn->prepare("
                INSERT INTO member (uid, pw, name, birth, number, email)
                VALUES (:uid, :pw, :name, :birth, :number, :email)
            ");
            $insert_stmt->execute([
                ':uid' => $uid,
                ':pw' => $default_password,
                ':name' => $name,
                ':birth' => $default_birth,
                ':number' => $number,
                ':email' => $email
            ]);
            echo "✅ $uid 생성됨<br>";
        } else {
            echo "⚠️ $uid 는 이미 존재합니다<br>";
        }
    }

    $conn->commit();
    echo "<br><strong>🎉 더미 사용자 {$number_of_users}명 생성 완료</strong>";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "❌ 오류 발생: " . $e->getMessage();
}
?>
