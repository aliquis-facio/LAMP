<?php
include_once("../functions/sql_connect.php"); // $conn 은 PDO 객체라고 가정

// 현재 시간 기준
date_default_timezone_set("Asia/Seoul");
$now = date("Y-m-d H:i:s");

// 1. 유저 목록 가져오기
$user_stmt = $conn->prepare("SELECT uid FROM member");
$user_stmt->execute();
$user_list = $user_stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($user_list)) {
    exit("❌ 사용자 계정이 없습니다. 먼저 회원을 등록해주세요.");
}

// 2. 게시글 INSERT 준비
$sql = "INSERT INTO board (pid, writer, title, content, createdDate, view) 
        VALUES (:pid, :writer, :title, :content, :createdDate, :view)";
$stmt = $conn->prepare($sql);

// 3. 더미 게시글 생성
for ($i = 1; $i <= 100; $i++) {
    $writer = $user_list[array_rand($user_list)]; // 랜덤 유저 선택
    $title = "더미 제목 $i";
    $content = "이것은 더미 게시글입니다. 게시글 번호: $i\n자동 생성된 게시물입니다.";
    $createdDate = $now;
    $pid = hash('sha256', $title . $writer . $createdDate);
    $view = rand(0, 200);

    $stmt->execute([
        ':pid' => $pid,
        ':writer' => $writer,
        ':title' => $title,
        ':content' => $content,
        ':createdDate' => $createdDate,
        ':view' => $view
    ]);
}

echo "✅ 랜덤 유저 기반 더미 게시글 100개가 생성되었습니다.";
?>
