<?php
include_once("./error_report.php");
include_once("./sql_connect.php"); // $conn은 PDO 객체

if (!session_id()) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_SESSION['uid'] ?? null;
    date_default_timezone_set('Asia/Seoul');
    $modifiedDate = (new DateTime("now"))->format('Y-m-d H:i:s');
    $title = $_POST["title"] ?? '';
    $content = $_POST["content"] ?? '';
    $pid = $_POST["pid"] ?? '';
    $fid =  null;
    $fName = null;
    
    // 유효성 검사
    if (!$title || !$content) {
        echo    "<script>
                    alert('입력값이 누락되었습니다');
                    history.back();
                </script>";
        exit;
    }
    
    try {
        // 업로드 되어있는 이미지가 있는 지 확인
        $select_sql =   "SELECT fid, fName
                        FROM board
                        WHERE pid = :pid";
        
        // 게시글 업데이트
        if ($fid !== null && $fName !== null) {
            $update_sql = "UPDATE board 
                       SET title = :title, content = :content, createdDate = :createdDate, fid = :fid, fName = :fName
                       WHERE pid = :pid";
        } else {
            $update_sql = "UPDATE board 
                        SET title = :title, content = :content, createdDate = :createdDate 
                        WHERE pid = :pid";
        }
    
        $stmt = $conn->prepare($update_sql);

        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':createdDate', $modifiedDate);

        // 첨부 이미지 존재 시
        // 기존 이미지에서 변경할 경우
        // 기존 이미지를 삭제할 경우
        // 기존 이미지를 유지할 경우
        if ($fid !== null && $fName !== null) {
            $stmt->bindParam(':fid', $fid);
            $stmt->bindParam(':fName', $fName);
        }

        $stmt->execute();

        echo    "<script>
                    alert('수정되었습니다');
                    location.replace('../layouts/post-view.php?pid={$pid}');
                </script>";
    } catch (PDOException $e) {
        echo    "<script>
                    alert('오류가 발생했습니다');
                    history.back();
                </script>";
        exit;
    }
} else {
    $pid = $_POST['pid'];
    echo    "<script>
                alert('잘못된 접근 방식입니다');
                location.replace('../layouts/post-view.php?pid={$pid}');
            </script>";
    exit;
}
?>
