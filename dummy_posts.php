<?php
include_once("./functions/sql_connect.php"); // $conn 은 PDO 객체라고 가정

// 작성자 고정 또는 랜덤
$writer = "test";

// 현재 시간 기준
date_default_timezone_set("Asia/Seoul");
$now = date("Y-m-d H:i:s");

$sql = "INSERT INTO board (id, writer, title, content, createdDate, view) VALUES (:id, :writer, :title, :content, :createdDate, :view)";
$stmt = $conn->prepare($sql);

for ($i = 30; $i <= 130; $i++) {
    $title = "test" . $i;
    $content = "이것은 테스트 내용입니다. 반복 글 번호: " . $i;
    $createdDate = $now;
    $pid = hash('sha256', $title . $writer . $created_date);
    $view = rand(0, 100); // 조회수 랜덤

    $stmt->execute([
        'id' => $pid,
        ':writer' => $writer,
        ':title' => $title,
        ':content' => $content,
        ':createdDate' => $createdDate,
        ':view' => $view
    ]);
}

echo "100개의 게시글이 성공적으로 삽입되었습니다.";
?>
