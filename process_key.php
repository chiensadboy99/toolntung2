<?php
session_start();
include 'db.php'; // Kết nối CSDL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_key = trim($_POST['access_key']);
    $device_id = trim($_POST['device_id']);

    $stmt = $conn->prepare("SELECT * FROM access_keys WHERE access_key = ?");
    $stmt->bind_param("s", $user_key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $key_data = $result->fetch_assoc();

        if (empty($key_data['device_id'])) {
            $update = $conn->prepare("UPDATE access_keys SET device_id = ? WHERE access_key = ?");
            $update->bind_param("ss", $device_id, $user_key);
            $update->execute();

            $_SESSION['username'] = $user_key;
            $_SESSION['message'] = "✅ Key đã được kích hoạt thành công!";
            header("Location: game.php");
            exit();
        } elseif ($key_data['device_id'] === $device_id) {
            $_SESSION['username'] = $user_key;
            $_SESSION['message'] = "✅ Key hợp lệ! Truy cập thành công.";
            header("Location: game.php");
            exit();
        } else {
            $_SESSION['message'] = "❌ Key này đã bị khóa bởi thiết bị khác.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "❌ Key không hợp lệ.";
        header("Location: index.php");
        exit();
    }
}
