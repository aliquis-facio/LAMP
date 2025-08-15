<?php
include_once("../functions/sql_connect.php"); // $conn은 PDO 객체

date_default_timezone_set("Asia/Seoul");

// 1. 전체 사용자 uid 목록 가져오기
$stmt1 = $conn->query("SELECT uid FROM member");
$users = $stmt1->fetchAll(PDO::FETCH_COLUMN);

if (count($users) === 0) {
    die("❌ 유저가 존재하지 않습니다.");
}

// 2. 더미 댓글 내용
$dummy_comments = [
    "좋은 글 감사합니다!",
    "많은 도움이 되었어요.",
    "내용이 명확하네요.",
    "공감합니다.",
    "자주 올게요 :)",
    "질문이 있습니다!",
    "재밌게 읽었습니다."
];

// 3. 게시글 목록 가져오기
$stmt2 = $conn->query("SELECT pid FROM board");
$pids = $stmt2->fetchAll(PDO::FETCH_COLUMN);

// 4. 댓글 삽입용 prepare
$stmt3 = $conn->prepare("
    INSERT INTO coment (cid, pid, createdDate, writer, reply)
    VALUES (:cid, :pid, :createdDate, :writer, :reply)
");

foreach ($pids as $pid) {
    echo "[+] 게시글 ID: $pid<br>";

    for ($i = 0; $i < 3; $i++) {
        // 작성자 및 댓글 내용 무작위 선택
        $writer = $users[array_rand($users)];
        $reply = $dummy_comments[array_rand($dummy_comments)];
        $created_date = date("Y-m-d H:i:s");
        $cid = hash('sha256', $pid . $writer . $created_date . rand());

        $stmt3->execute([
            ':cid' => $cid,
            ':pid' => $pid,
            ':createdDate' => $created_date,
            ':writer' => $writer,
            ':reply' => $reply
        ]);
    }
}

echo "<br>✅ 모든 게시글에 랜덤 유저 댓글 3개씩 삽입 완료.";
?>
