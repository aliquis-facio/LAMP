<?php
// DB 접속 정보 설정
$host = 'localhost';
$dbname = 'LAMP';
$user = 'admin';
$pass = 'student1234';

try {
    // 기본 연결 (데이터베이스 지정 없이)
    $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 기존 DB 삭제
    $pdo->exec("DROP DATABASE IF EXISTS `$dbname`");
    echo "[+] 기존 데이터베이스 '$dbname' 삭제 완료.<br>";

    // DB 생성
    $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8 COLLATE utf8_general_ci");
    echo "[+] 새로운 데이터베이스 '$dbname' 생성 완료.<br>";

    // 새 DB로 재연결
    $pdo->exec("USE `$dbname`");

    // 1. member 테이블 생성
    $pdo->exec("
        CREATE TABLE member (
            uid VARCHAR(50) PRIMARY KEY,
            pw VARCHAR(255) NOT NULL,
            name VARCHAR(50) NOT NULL,
            birth DATE NOT NULL,
            number VARCHAR(20),
            email VARCHAR(100),
            createdDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    echo "[+] 'member' 테이블 생성 완료.<br>";

    // 2. board 테이블 생성
    $pdo->exec("
        CREATE TABLE board (
            pid VARCHAR(255) PRIMARY KEY,
            writer VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            content TEXT,
            fid VARCHAR(50),
            fName VARCHAR(255),
            createdDate DATETIME DEFAULT CURRENT_TIMESTAMP,
            view INT DEFAULT 0,
            FOREIGN KEY (writer) REFERENCES member(uid) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    echo "[+] 'board' 테이블 생성 완료.<br>";

    // 3. coment 테이블 생성
    $pdo->exec("
        CREATE TABLE coment (
            cid VARCHAR(255) PRIMARY KEY,
            pid VARCHAR(255) NOT NULL,
            writer VARCHAR(50) NOT NULL,
            reply TEXT NOT NULL,
            createdDate DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (pid) REFERENCES board(pid) ON DELETE CASCADE,
            FOREIGN KEY (writer) REFERENCES member(uid) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    echo "[+] 'coment' 테이블 생성 완료.<br>";

    // 4. 관리자 계정 생성
    $admin_id = "admin";
    $admin_pw = hash('sha512', 'admin1234');
    $stmt = $pdo->prepare("INSERT INTO member (uid, pw, name, birth, number, email)
                           VALUES (:id, :pw, '관리자', '1990-01-01', '010-0000-0000', 'admin@example.com')");
    $stmt->execute([':id' => $admin_id, ':pw' => $admin_pw]);
    echo "[+] 관리자 계정 'admin' 생성 완료.<br>";

    echo "<br><strong>✅ 전체 초기화가 완료되었습니다.</strong>";

} catch (PDOException $e) {
    echo "❌ 초기화 실패: " . $e->getMessage();
}
?>
