<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $image = '';

    // Xử lý hình ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        // Di chuyển file hình ảnh vào thư mục uploads
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        }
    }

    // Lưu bài đăng vào file posts.txt
    $post = $content . '|||' . $image . PHP_EOL;
    file_put_contents('posts.txt', $post, FILE_APPEND | LOCK_EX);

    // Chuyển hướng về trang chính
    header('Location: index.html');
    exit;
}
?>
