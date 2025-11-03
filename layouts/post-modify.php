<!DOCTYPE HTML>
<html>

<?php
include_once("../includes/head.php");
include("../functions/user_session.php");
include("../functions/sql_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uid = $_SESSION['uid'] ?? null;
    $pid = $_GET['pid'] ?? null;

    try {
        $select_sql =   "SELECT title, content, fid, fName
                        FROM board
                        WHERE pid = :pid";
        $stmt = $conn->prepare($select_sql);
        $stmt->execute([':pid' => $pid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $title = $row['title'] ?? "";
            $content = $row['content'] ?? "";
            $fid = $row['fid'] ?? null;
            $fName = $row['fName'] ?? null;
            $img = ($fid . $fName) ?? null;
        } else {
            echo    "<script>
                        alert('게시글을 찾을 수 없습니다.');
                        history.back();
                    </script>";
            exit;
        }
    } catch (PDOException $e) {
        echo    "<script>
                    alert('게시글을 찾을 수 없습니다.');
                    history.back();
                </script>";
        exit;
    }
} else {
    echo    "<script>
                alert('잘못된 접근입니다.');
                history.back();
            </script>";
    exit;
}
?>

<body>
    <div class="logo">
        <?php include_once("../includes/nav.php"); ?>
    </div>

    <div>
        <h1>수정하기</h1>
        <button form="post_modify_form" class="orange">수정</button>
        <hr>
    </div>

    <div>
        <form id="post_modify_form" action="../functions/post_modify_proc.php" method="post">
            <input id="title_modify_input" class="post_title" type="text" name="title"
                   value="<?php echo htmlspecialchars($title); ?>" required>

            <textarea class="post_content" name="content" required><?php echo htmlspecialchars($content); ?></textarea>

            <input type="hidden" name="pid" value="<?php echo htmlspecialchars($pid); ?>">

            <?php if (!empty($img)): ?>
            <div class="image_box">
                <img src="../uploads/"<?= htmlspecialchars($img) ?> alt="첨부 이미지">
                <input type="file" name="file">
            </div>
            <?php endif; ?>
        </form>
    </div>

    <div>
        <a href="./index.php">뒤로 가기</a>
    </div>
</body>

</html>
