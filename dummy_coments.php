<?php
include_once("./functions/sql_connect.php"); // $conn은 PDO 객체

date_default_timezone_set("Asia/Seoul");
$writers = ['test', 'test1', 'test4'];
$dummy_comments = [
    "좋은 글이네요!",
    "잘 읽고 갑니다.",
    "도움이 되었어요.",
    "재미있게 봤어요.",
    "감사합니다!",
    "질문이 있습니다.",
    "내용이 명확하네요."
];

// 게시글 ID 목록 불러오기
$stmt1 = $conn->query("SELECT id FROM board");
$post_ids = $stmt1->fetchAll(PDO::FETCH_COLUMN);

// 댓글 삽입용 prepare
$stmt2 = $conn->prepare("INSERT INTO coment (id, postId, createdDate, writer, reply) VALUES (:id, :postId, :createdDate, :writer, :reply)");

foreach ($post_ids as $post_id) {
    $num_comments = rand(3, 4);
    echo $post_id . "\n";
    for ($i = 0; $i < $num_comments; $i++) {
        $writer = $writers[array_rand($writers)];
        $reply = $dummy_comments[array_rand($dummy_comments)];
        $created_date = date("Y-m-d H:i:s");
        $comment_id = hash('sha256', $post_id . $writer . $created_date . rand());

        $stmt2->execute([
            ':id' => $comment_id,
            ':postId' => $post_id,
            ':createdDate' => $created_date,
            ':writer' => $writer,
            ':reply' => $reply
        ]);
    }
}

echo "모든 게시글에 댓글을 삽입했습니다.";
?>
