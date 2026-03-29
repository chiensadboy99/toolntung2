<?php
// login.php - Đăng nhập admin với giao diện hiện đại công nghệ
session_start();
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $message = 'error|Vui lòng nhập đầy đủ thông tin.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin_account WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin'] = $username;
                header("Location: admin.php");
                exit;
            } else {
                $message = 'error|Sai mật khẩu.';
            }
        } else {
            $message = 'error|Tài khoản không tồn tại.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      box-sizing: border-box;
    }
    body, html {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: 'Orbitron', sans-serif;
      background: linear-gradient(135deg, #0f0f0f, #1c1c1c);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .container-login {
      background: rgba(0, 255, 204, 0.06);
      border: 1px solid #00ffc3;
      border-radius: 20px;
      backdrop-filter: blur(12px);
      width: 90%;
      max-width: 420px;
      padding: 40px 30px;
      color: #fff;
      box-shadow: 0 0 30px rgba(0, 255, 204, 0.15);
      animation: fadeIn 1.2s ease;
    }
    .form-title {
      font-size: 26px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 25px;
      color: #00ffc3;
    }
    .form-control {
      background-color: rgba(255,255,255,0.1);
      border: 1px solid #00ffcc;
      color: white;
      border-radius: 10px;
    }
    .form-control::placeholder {
      color: #ccc;
    }
    .btn-login {
      background-color: #00ffcc;
      color: #000;
      font-weight: bold;
      border-radius: 10px;
      margin-top: 10px;
    }
    .glow {
      position: absolute;
      width: 400px;
      height: 400px;
      background: #00ffc3;
      filter: blur(120px);
      opacity: 0.2;
      animation: float 6s ease-in-out infinite;
    }
    .glow-1 { top: 10%; left: 5%; }
    .glow-2 { bottom: 10%; right: 5%; animation-delay: 3s; }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }
  </style>
</head>
<body>
  <div class="glow glow-1"></div>
  <div class="glow glow-2"></div>
  <div class="container-login">
    <div class="form-title">🚀 Đăng nhập Admin TínhiOS</div>
    <form method="post">
      <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
      </div>
      <button type="submit" class="btn btn-login w-100">Đăng nhập</button>
    </form>
  </div>

  <?php if ($message !== ''): ?>
  <script>
    const [icon, msg] = "<?= $message ?>".split('|');
    Swal.fire({ icon, title: msg, timer: 2200, showConfirmButton: false });
  </script>
  <?php endif; ?>
</body>
</html>