<!DOCTYPE HTML>
<html>

<?php
include_once("../includes/head.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: ./sign-in.php");
}

include_once("./inner/user_session.php");
include_once("./inner/sql_connect.php");
?>

<body>
    <div class="logo">
        <?php include_once("../includes/nav.php"); ?>
    </div>

    <div class="headBox">
        <?php
            $user_id = $_SESSION['user_id'] ?? '';
            $writer = $_GET['writer'] ?? '';

            echo "<h1>" . htmlspecialchars($writer) . "님의 글 보기</h1>";
            if ($user_id !== $writer) {
                echo "<a href=\"./post-list.php?writer=" . urlencode($user_id) . "\">내 게시글</a>";
            }

            $stmt = $conn->prepare("SELECT * FROM board WHERE writer = :writer ORDER BY createdDate DESC");
            $stmt->execute([':writer' => $writer]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $cnt = count($rows);
            echo "<p class='the_num_of_post'>{$cnt}개의 글</p>";
        ?>
        <a href="./post-write.php">글쓰기</a>
        <a class="orange" href="./index.php">뒤로 가기</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>등록일</th>
                <th>조회수</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $num = 1;
                foreach ($rows as $row) {
                    $created_date = str_replace("-", ".", substr($row['created_date'], 0, 16));
                    echo "<tr>
                        <td>{$num}</td>
                        <td><a href=\"./post_view.php?post_id=" . htmlspecialchars($row['post_id']) . "\">" . htmlspecialchars($row['title']) . "</a></td>
                        <td><a href=\"./post_list.php?writer=" . htmlspecialchars($row['writer']) . "\">" . htmlspecialchars($row['writer']) . "</a></td>
                        <td>{$created_date}</td>
                        <td>" . htmlspecialchars($row['post_view']) . "</td>
                    </tr>";
                    $num++;
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='5'>DB 오류: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <div class="links">
                        <a href="#">&laquo;</a>
                        <a class="active" href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        <a href="#">&raquo;</a>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
