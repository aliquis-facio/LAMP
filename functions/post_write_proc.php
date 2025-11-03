<?php
include_once("./error_report.php");
include_once("./sql_connect.php");

if (!session_id()) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $writer = htmlspecialchars($_SESSION['uid']);
    date_default_timezone_set('Asia/Seoul');
    $created_date = date('Y-m-d H:i:s');
    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["substance"]);
    $pid = hash('sha256', $title . $writer . $created_date);
    $view = 0;

    $fid = null;
    $fName = null;

    // 파일 업로드 처리
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        echo $_FILES["image"];
        // 업로드 폴더
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $image = $_FILES["image"];
        $fName = basename($image["name"]);

        $fid = uniqid();
        $safeFileName = $fid . preg_replace("/[^A-Za-z0-9_.-]/", $fName);

        if ($image['size'] > 1 * 1024 * 1024 * 1024) { # 1MB
            die("파일이 너무 큽니다.");
        }

        // 확장자, MIME 검사
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $image['tmp_name']);
        $ext = strtolower(pathinfo($fName, PATHINFO_EXTENSION));
        finfo_close($finfo);

        $allowedExt = ["jpg", "png", "gif", "jpeg"];
        $allowedMimes = ['image/jpeg', 'image/png', ];
        if (!in_array($mime, $allowedMimes) || !in_array($ext, $allowedExt)) {
            die("허용되지 않는 파일 형식입니다.");
        }

        // 파일 업로드
        $destination = $targetDir . $safeFileName;
        if (!move_uploaded_file($image['tmp_name'], $destination)) {
            die("파일 이동 실패");
        }
    }

    try {
        // insert query 구성
        if ($fid !== null && $fName !== null) {
            $sql = "INSERT INTO board (pid, writer, title, content, fid, fName, createdDate, view)
                    VALUES (:pid, :writer, :title, :content, :fid, :fName, :createdDate, :view)";
        } else {
            $sql = "INSERT INTO board (pid, writer, title, content, createdDate, view)
                    VALUES (:pid, :writer, :title, :content, :createdDate, :view)";
        }

        $stmt = $conn->prepare($sql);

        // 공통 바인딩
        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':writer', $writer);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':createdDate', $created_date);
        $stmt->bindParam(':view', $view, PDO::PARAM_INT);

        // 첨부 이미지 존재 시
        if ($fid !== null && $fName !== null) {
            $stmt->bindParam(':fid', $fid);
            $stmt->bindParam(':fName', $fName);
        }

        $stmt->execute();

        echo    "<script>
                    alert('등록되었습니다');
                    location.replace('../layouts/index.php');
                </script>";
        exit;
    } catch (PDOException $e) {
        echo    "<script>
                    alert('오류가 발생했습니다');
                    history.back();
                </script>";
        exit;
    }
} else {
    echo    "<script>
                alert('잘못된 접근 방식입니다');
                location.replace('../layouts/post-write.php');
            </script>";
    exit;
}
?>
