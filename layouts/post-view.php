<?php
include_once("../includes/head.php");
include_once("../functions/user_session.php");
include_once("../functions/sql_connect.php");

$user_id = $_SESSION['user_id'];
$post_id = $_GET['post_id'];

// 게시글 조회
$select_sql = "SELECT * FROM board WHERE id = ?";
$stmt = $conn->prepare($select_sql);
$stmt->execute([$post_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $writer = $row['writer'];
    $view = $row['view'];
    $createdDate = str_replace("-", ".", substr($row['createdDate'], 0, 16));
    $title = html_entity_decode($row['title']);
    $substance = nl2br(html_entity_decode($row['content'])); // 줄바꿈 유지
    $fid = $row['fid'] ?? null;
    $fName = $row['fName'] ?? null;
    $img = ($fid . $fName) ?? null;
    // 조회수 증가
    if ($writer !== $user_id) {
        $update_sql = "UPDATE board SET view = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->execute([$view + 1, $post_id]);
    }
} else {
    echo "<script>alert('오류가 발생했습니다');</script>";
    exit;
}
?>

<body>
    <div class="logo">
        <?php include_once("../includes/nav.php"); ?>
    </div>

    <div class="container">
        <div class="headBox">
            <h1><?= $title ?></h1>
            <p class='post_header'><?= htmlspecialchars($writer) ?>님</p>
            <p class='post_header'><?= $createdDate ?></p>
        </div>

        <hr>

        <div class="bodyBox">
            <div id='post_content' class="contentBox">
                <?= $substance ?>
            </div>
            <?php if ($isset(img)): ?>
                <div class="image_box">
                    <img src="../uploads/"<?= .htmlspecialchars($img) ?> alt="첨부 이미지">
                    <a href=<?="../functions/download.php?file={basename(../uploads.$fid.$fName)}"?>>다운로드</a>
                </div>
            <?php endif; ?>
            <?php if ($writer !== $user_id): ?>
                <a id="writer_link" class="left" href="./post-list.php?writer=<?= urlencode($writer) ?>">
                    <?= htmlspecialchars($writer) ?>님의 게시글 더보기
                </a>
            <?php else: ?>
                <span class='right'>
                    <a class='orange' href='./post-modify.php?post_id=<?= $post_id ?>'>수정하기</a>
                    <a class='red' onclick='post_delete("<?= $post_id ?>")'>삭제하기</a>
                </span>
            <?php endif; ?>
        </div>

        <hr>

        <div class="footBox">
            <div class="coment_list">
                <!-- 댓글 목록 -->
                <ul>
                <?php
                    $coment_sql = "SELECT * FROM coment WHERE postId = ? ORDER BY createdDate ASC";
                    $stmt = $conn->prepare($coment_sql);
                    $stmt->execute([$post_id]);
                    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($comments as $row):
                        $coment_writer = htmlspecialchars($row['writer']);
                        $coment = nl2br(html_entity_decode($row['reply']));
                        $coment_created_date = str_replace("-", ".", substr($row['createdDate'], 0, 16));
                        $coment_id = htmlspecialchars($row['id']);
                ?>
                    <div id="<?= $coment_id ?>">
                        <p class='thin_font coment'><?= $coment ?></p>
                        <span class='strong_font coment'><?= $coment_writer ?>님</span>
                        <span class='grey small_font coment'><?= $coment_created_date ?></span>
                        <?php if ($coment_writer == $user_id): ?>
                            <button class='orange' onclick='coment_modify("<?= $coment_id ?>", "<?= $post_id ?>")'>수정</button>
                            <button class='red' onclick='coment_delete("<?= $coment_id ?>", "<?= $post_id ?>")'>삭제</button>
                        <?php endif; ?>
                    </div>
                    <hr>
                <?php endforeach; ?>
                </ul>
            </div>

            <div>
                <form id="coment_form" action="../functions/coment_write.php" method="post">
                    <input id="reply_input" type="text" name="reply" placeholder="댓글을 남겨보세요">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    <button class="orange" type="button" onclick="coment_write_submit()">등록</button>
                </form>
            </div>
        </div>
    </div>
</body>
