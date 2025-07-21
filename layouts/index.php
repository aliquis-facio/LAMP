<!DOCTYPE HTML>
<html>

<?php
include_once("../includes/head.php");
include_once("../functions/user_session.php");
include_once("../functions/sql_connect.php"); // $conn is PDO
include_once("../functions/error_report.php");

// 현재 유저의 작성글 수
$stmt1 = $conn->prepare("SELECT COUNT(id) AS CNT FROM board WHERE writer = :writer");
$stmt1->execute([':writer' => $user_id]);
$row = $stmt1->fetch(PDO::FETCH_ASSOC);
$cnt_post = $row["CNT"] ?? 0;

// 현재 유저의 댓글 수
$stmt2 = $conn->prepare("SELECT COUNT(id) AS CNT FROM coment WHERE writer = :writer");
$stmt2->execute([':writer' => $user_id]);
$row = $stmt2->fetch(PDO::FETCH_ASSOC);
$cnt_coment = $row["CNT"] ?? 0;

// 게시판 검색
$search_string = isset($_GET['search']) ? htmlentities($_GET['search']) : "";

// 페이지네이션
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // 1보다 작을 수 없게
$page_size = 15;
$start = ($page - 1) * $page_size;
$num = $start;
$limit = $start + $page_size;

if ($search_string == "") {
    $stmt4 = $conn->prepare("SELECT COUNT(*) FROM board");
    $stmt4->execute();
} else {
    $stmt4 = $conn->prepare("SELECT COUNT(*) FROM board WHERE title LIKE :search");
    $stmt4->execute([':search' => "%{$search_string}%"]);
}
$total_post = $stmt4->fetchColumn();

if ($search_string == "") {
    $sql = "
    SELECT b.*, COUNT(c.id) AS coment_count
    FROM board b
    JOIN coment c ON b.id = c.id
    GROUP BY b.id
    ORDER BY b.createdDate DESC
    LIMIT :start, :limit
    ";

    $stmt3 = $conn->prepare($sql);
    $stmt3->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt3->bindValue(':limit', $page_size, PDO::PARAM_INT);
    $stmt3->execute();
} else {
    $sql = "
    SELECT b.*, COUNT(c.id) AS coment_count
    FROM board b
    JOIN coment c ON b.id = c.id
    WHERE title LIKE :search
    GROUP BY b.id
    ORDER BY b.createdDate DESC
    LIMIT :start, :limit
    ";

    $stmt3 = $conn->prepare($sql);
    $stmt3 = $conn->prepare("SELECT * FROM board WHERE title LIKE :search ORDER BY createdDate DESC LIMIT :start, :limit");
    $stmt3->bindValue(':search', "%{$search_string}%", PDO::PARAM_STR);
    $stmt3->bindValue(':start', $start, PDO::PARAM_INT);
    $stmt3->bindValue(':limit', $page_size, PDO::PARAM_INT);
    $stmt3->execute();
}

$posts = $stmt3->fetchAll(PDO::FETCH_ASSOC);

$total_pages = ceil($total_post / $page_size);

$pagination_size = 5;
$current_block = ceil($page / $pagination_size);
$start_page = ($current_block - 1) * $pagination_size + 1;
$end_page = min($start_page + $pagination_size - 1, $total_pages);
?>

<body>
<div class="container">
    <div class="head_box">
        <?php include_once("../includes/nav.php"); ?>
        <button class="red logout" type="button" onclick="location.href = '../functions/logout.php'">LOG OUT</button>
    </div>

    <div class="side_box">
        <p><b><?php echo $user_id ?></b></p>
        <p><a href="./mypage.php">내 정보</a></p>
        <p><a href="./post-list.php?writer=<?php echo $user_id ?>">내 게시글</a></p>
        <p>내가 쓴 게시글: <?php echo $cnt_post ?>개</p>
        <p>내가 쓴 댓글: <?php echo $cnt_coment ?>개</p>
        <a href="./post-write.php">글쓰기</a>
    </div>

    <div class="body_box">
        <div class="title_panel">
            <div>
                <form id="post_search" class="search_box" action="">
                    <input type="text" name="search" value="" placeholder="제목">
                    <button class="green" type="submit">검색</button>
                </form>
            </div>

            <p class="board_title">자유게시판</p>
            <p class='the_num_of_post'><?php echo $total_post ?>개의 글</p>
        </div>

        <hr>

        <div class="body_panel">
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

                    foreach ($posts as $row) {
                        $created_date = str_replace("-", ".", substr($row['createdDate'], 0, 16));
                        echo "<tr>
                            <td>{$num}</td>
                            <td><a href=\"./post-view.php?post_id={$row['id']}\">{$row['title']}</a></td>
                            <td><a href=\"./post-list.php?writer={$row['writer']}\">{$row['writer']}</a></td>
                            <td>{$created_date}</td>
                            <td>{$row['view']}</td>
                        </tr>";
                        $num++;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="links">
                                <?php
                                $total_pages = ceil($total_post / $page_size);
                                $pagination_size = 5;
                                $current_block = ceil($page / $pagination_size);
                                $start_page = ($current_block - 1) * $pagination_size + 1;
                                $end_page = min($start_page + $pagination_size - 1, $total_pages);

                                echo "<a href='?page=1'>&laquo;</a>";
                                if ($page > 1) {
                                    echo "<a href='?page=" . ($page - 1) . "'>&lt;</a>";
                                }

                                for ($i = $start_page; $i <= $end_page; $i++) {
                                    $active = ($i == $page) ? "class='active'" : "";
                                    echo "<a $active href='?page=$i'>$i</a>";
                                }

                                if ($page < $total_pages) {
                                    echo "<a href='?page=" . ($page + 1) . "'>&gt;</a>";
                                }
                                echo "<a href='?page=$total_pages'>&raquo;</a>";
                                ?>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php
echo "request url: " . $_SERVER['REQUEST_URI'] . "\n";
echo "php self: " . $_SERVER['PHP_SELF'] . "\n";
echo "query string: " . $_SERVER['QUERY_STRING'] . "\n";
?>
</body>
</html>
