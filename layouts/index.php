<!DOCTYPE HTML>
<html>

<?php
    include_once("../includes/head.php");
    include_once("../functions/user_session.php");
    include_once("../functions/sql_connect.php");
    include_once("../functions/error_report.php");

    // Get user written post data
    $select_sql = "SELECT * FROM `board` WHERE writer='{$user_id}'";
    $stmt->prepare($select_sql);
    $stmt->execute();
    $ret = $stmt->get_result();
    $cnt_post = $ret->num_rows;
    $stmt->reset();
    
    // Get user written coment data
    $select_sql = "SELECT * FROM `coment` WHERE writer='{$user_id}'";
    $stmt->prepare($select_sql);
    $stmt->execute();
    $ret = $stmt->get_result();
    $cnt_coment = $ret->num_rows;

    // board
    $search_string = isset($_GET['search']) ? $_GET['search']:"";
    
    if ($search_string == "") {
        // Get all post
        $select_sql = "SELECT * FROM `board` ORDER BY created_date DESC";
        $stmt->prepare($select_sql);
        $stmt->execute();
        $ret = $stmt->get_result();
        $num_of_total_post = $ret->num_rows;
    } else {
        // Get post
        $search_string = "%{$search_string}%";
        $select_sql = "SELECT * FROM `board` WHERE `title` LIKE ? ORDER BY created_date DESC";
        $stmt->prepare($select_sql);
        $stmt->bind_param('s', $search_string);
        $stmt->execute();
        $ret = $stmt->get_result();
        $num_of_total_post = $ret->num_rows;
    }
?>

<body>
    <div class="container">
        <div class = "head_box">
            <?php include_once("../includes/nav.php"); ?>

            <button class="red logout" type="button" onclick="location.href = '../functions/logout.php'">LOG OUT</button>
        </div>
        
        <div class="side_box">
            <p><b><?php echo $user_id?></b></p>
            <p><a href="./mypage.php">내 정보</a></p>
            <p><a href="./post-list.php?writer=<?php echo $user_id?>">내 게시글</a></p>
            <p>내가 쓴 게시글: <?php echo $cnt_post?>개</p>
            <p>내가 쓴 댓글: <?php echo $cnt_coment?>개</p>
            <a href="./post-write.php">글쓰기</a>
        </div>
    
        <div class="body_box">
            <div class = "title_panel">
                <div>
                    <form id="post_search" class="search_box" action="">
                        <input type="text" name="search" value="">
                        <button class="green" type="submit">검색</button>
                    </form>
                </div>
    
                <p class="board_title">자유게시판</p>
                <p class='the_num_of_post'><?php echo $num_of_total_post?>개의 글</p>
            </div>
        
            <hr>
        
            <div class = "body_panel">
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
                            $num = 1;
                            $page_size = 15;
                            $page_is_empty = false;
                            $page_total_post = ceil($num_of_total_post / $page_size);
                            $page_num = 1;
                            $page_has_prev = false;
                            $page_has_next = false;

                            if ($ret) {
                                while($row = $ret->fetch_assoc()) {
                                    $created_date = str_replace("-", ".", substr($row['created_date'], 0, 16));
                                    echo "<tr>
                                    <td>{$num}</td>
                                    <td><a href=\"./post-view.php?post_id={$row['id']}\">{$row['title']}</a></td>
                                    <td><a href=\"./post-list.php?writer={$row['writer']}\">{$row['writer']}</a></td>
                                    <td>{$created_date}</td>
                                    <td>{$row['view']}</td>
                                    </tr>";
                                    $num += 1;
                                }
                            } else {
                                echo "오류 발생했다.<br>";
                            }
        
                            $stmt->close();
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="links">
                                    <a href="#1">&laquo;</a>
                                    <?php
                                    $p1 = $page_num-1;
                                    $p2 = $page_num*5-4;
                                    $p3 = $page_num*5-3;
                                    $p4 = $page_num*5-2;
                                    $p5 = $page_num*5-1;
                                    $p6 = $page_num*5;
                                    $p7 = ($page_num < $page_total_post) ? $page_num+1 : $page_num;
                                    echo "<a href=\"#{$p1}\">&lt;</a>";
                                    if ($page_total_post >= $p2) echo "<a href=\"#{$p2}\">{$p2}</a>";
                                    if ($page_total_post >= $p3) echo "<a href=\"#{$p3}\">{$p3}</a>";
                                    if ($page_total_post >= $p4) echo "<a href=\"#{$p4}\">{$p4}</a>";
                                    if ($page_total_post >= $p5) echo "<a href=\"#{$p5}\">{$p5}</a>";
                                    if ($page_total_post >= $p6) echo "<a href=\"#{$p6}\">{$p6}</a>";
                                    echo "<a href=\"#{$p7}\">&gt;</a>";
                                    echo "<a href=\"#{$page_total_post}\">&raquo;</a>";
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