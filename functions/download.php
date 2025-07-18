<?php
$targetDir = "uploads/";

if (!isset($_GET['file'] || !isset($_GET['fid']))) {
    die("파일명이 지정되지 않았습니다.");
}

$filename = basename($_GET['file']);
$filepath = $targetDir . $filename;

// 파일 존재 여부 확인
if (!file_exists($filepath)) {
    die("파일을 찾을 수 없습니다.");
}

// 보안상 경로 우회 방지
if (strpos($filename, '..') !== false || strpos($filename, '/') !== false) {
    die("잘못된 파일 요청입니다.");
}

// 다운로드 헤더 설정
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filepath));
readfile($filepath);
exit;
?>
