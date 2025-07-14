<!DOCTYPE HTML>
<html>

<?php
    include_once("../includes/head.php");
    include("../functions/user_session.php");
    include("../functions/sql_connect.php");

    $user_id = $_SESSION['user_id'];
    $post_id = $_GET['post_id'];
    
    // Get post data using prepare statement
    $select_sql = "SELECT * FROM board WHERE post_id = ?";
    $stmt->prepare($select_sql);
    $stmt->bind_param('s', $post_id);
    $stmt->execute();
    $ret = $stmt->get_result();

    if ($ret) {
        $row = $ret->fetch_assoc();
        
        $writer = $row['writer'];
        $view = $row['post_view'];
        $created_date = str_replace("-", ".", substr($row['created_date'], 0, 16));
        $title = $row['title'];
        $substance = $row['substance'];

        // Update view count
        if ($writer != $user_id) {
            $view += 1;

            $stmt->reset();
            $update_sql = "UPDATE board SET post_view = ? WHERE post_id = ?";
            $stmt->prepare($update_sql);
            $stmt->bind_param('is', $view, $post_id);
            $stmt->execute();
        }
    } else {
        echo "<script>alert('오류가 발생했습니다');</script>";
    }
?>

<body>
    <div class = "logo">
        <?php include_once("../includes/nav.php"); ?>
    </div>

    <div class="container">
        <div class = "headBox">
            <?php
                echo "<h1>{$title}</h1>
                <p class='post_header'>{$writer}님</p>
                <p class='post_header'>{$created_date}</p>";
            ?>
        </div>
        
        <hr>
    
        <div class = "bodyBox">
            <div id='post_content' class = "contentBox">
                <?php echo $substance; ?>
            </div>
            <?php
                if ($writer != $user_id)
                    echo "<a id=\"writer_link\" class='left' href=\"./post-list.php?writer={$writer}\">{$writer}님의 게시글 더보기</a>";
                else {
                    echo "<span class='right'>
                    <a class='orange' href='./post-modify.php?post_id={$post_id}'>수정하기</a>
                    <a class='red' onclick='post_delete(\"$post_id\")'>삭제하기</a>
                    </span>";
                }
            ?>
        </div>
    
        <hr>
        
        <div class = "footBox">
            <div class = "coment_list">
                <!-- 댓글 목록 -->
                <ul>
                    <?php
                        $stmt->reset();
                        $select_sql = "SELECT * FROM `coment` WHERE post_id=? ORDER BY created_date ASC";
                        $stmt->prepare($select_sql);
                        $stmt->bind_param('s', $post_id);
                        $stmt->execute();
                        $ret = $stmt->get_result();

                        if ($ret) {
                            while($row = $ret->fetch_assoc()) {
                                $coment_writer = $row['writer'];
                                $coment = $row['reply'];
                                $coment_created_date = str_replace("-", ".", substr($row['created_date'], 0, 16));
                                $coment_id = $row['coment_id'];

                                echo "<div id='$coment_id'>
                                <p class='thin_font coment'>{$coment}</p>
                                <span class='strong_font coment'>{$coment_writer}님</span>
                                <span class='grey small_font coment'>{$coment_created_date}</span>
                                ";
                                
                                if ($coment_writer == $user_id) {
                                    echo "
                                    <button class='orange' onclick='coment_modify(\"$coment_id\", \"$post_id\")'>수정</button>
                                    <button class='red' onclick='coment_delete(\"$coment_id\", \"$post_id\")'>삭제</button>
                                    ";
                                }
                                echo "</div>
                                <hr>";
                            }
                        } else {
                            echo "<script>alert('오류가 발생했습니다');</script>";
                        }
                    ?>
                </ul>
            </div>
            
            <div>
                <span>
                    <form id="coment_form" action="../functions/coment_write.php" method="post">
                        <input id="reply_input" type="text" name="reply" placeholder="댓글을 남겨보세요">
                        <?php
                            echo "<input type='hidden' name='post_id' value={$post_id}>";
                        ?>
                        <button class="orange" type="button" onclick="coment_write_submit()">등록</button>
                    </form>
                </span>
            </div>
        </div>
    </div>
</body>

</html>