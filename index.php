<?php
session_start();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>MrTínhiOS - Nhập Key</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Roboto', sans-serif;
      background: url('https://tooltxthanhtung.site/IMAGE/anh-nen-may-tinh-4k-chill_48991223469.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow-x: hidden;
      position: relative;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.08);
      border: 2px solid rgba(125, 88, 255, 0.3);
      box-shadow: 0 0 25px rgba(125, 88, 255, 0.4);
      backdrop-filter: blur(18px);
      border-radius: 20px;
      width: 100%;
      max-width: 400px;
      color: #fff;
      overflow: hidden;
      position: relative;
      z-index: 10;
      transition: transform 0.5s ease;
    }

    .header-box {
      background: linear-gradient(135deg, #7f5eff, #e04fff);
      padding: 25px 20px 20px 20px;
      text-align: center;
    }

    .header-box h1 {
      font-size: 26px;
      font-weight: 800;
      background: linear-gradient(90deg, #ffffff, #ffe6ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 5px;
    }

    .header-box p {
      font-size: 14px;
      color: #f8eaff;
      text-shadow: 0 0 3px rgba(255, 255, 255, 0.3);
    }

    .form-section {
      padding: 25px 25px 20px 25px;
      text-align: center;
    }

    .form-section h3 {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 15px;
      color: #ffffff;
    }

    input[type="text"] {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 15px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      background: rgba(255,255,255,0.15);
      color: #fff;
      font-size: 15px;
      outline: none;
    }

    input::placeholder {
      color: #ddd;
    }

    button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(145deg, #6c63ff, #483dff);
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(108, 99, 255, 0.4);
      transition: 0.3s ease;
    }

    button:hover {
      background: linear-gradient(145deg, #584bff, #3d34d1);
    }

    .bottom-links {
      margin-top: 15px;
      font-size: 13px;
    }

    .bottom-links a {
      color: #fff;
      text-decoration: underline;
    }

    .telegram {
      margin-top: 10px;
      font-size: 13px;
      opacity: 0.8;
    }

    .message {
      margin-top: 10px;
      font-size: 14px;
      color: yellow;
    }

    #toggle-button {
      position: absolute;
      left: calc(50% - 200px - 35px);
      top: 50%;
      transform: translateY(-50%);
      background: #6c63ff;
      color: #fff;
      font-size: 22px;
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
      z-index: 20;
      transition: all 0.4s ease;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .menu-container {
      position: absolute;
      top: 0;
      right: -100%;
      width: 100%;
      height: 100%;
      background: rgba(10, 10, 25, 0.96);
      backdrop-filter: blur(8px);
      padding: 30px 20px;
      transition: right 0.5s ease;
      z-index: 15;
      display: flex;
      flex-direction: column;
      color: #fff;
    }

    .menu-container.active {
      right: 0;
    }

    .menu-container h2 {
      font-size: 22px;
      margin-bottom: 25px;
      text-align: center;
      color: #fff;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      padding-bottom: 10px;
    }

    .menu-list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .menu-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 15px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 10px;
      font-size: 16px;
      box-shadow: 0 2px 10px rgba(125, 88, 255, 0.2);
    }

    .menu-item .left {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 500;
    }

    .menu-item .right {
      color: #ffd966;
      font-weight: bold;
    }

    .menu-note {
      margin-top: 25px;
      font-size: 14px;
      text-align: center;
      color: #ccc;
    }

    @media (max-width: 450px) {
      .login-container {
        max-width: 90%;
      }

      #toggle-button {
        left: 10px;
        transform: translateY(-50%);
      }

      .menu-item {
        font-size: 15px;
      }
    }
  </style>
</head>
<body>

  <div id="toggle-button">&#8249;</div>

  <div class="login-container" id="loginContainer">
    <div class="header-box">
      <h1>MrTínhiOS</h1>
      <p>Tool Game Tài Xỉu Uy Tín</p>
    </div>

    <div class="form-section">
      <h3>Nhập key hệ thống</h3>
      <form method="post" action="process_key.php">
        <input type="text" name="access_key" placeholder="Nhập key bạn đã được cấp..." required>
        <button type="submit">Xác thực</button>
      </form>

      <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <div class="bottom-links">
        Chưa có key? <a href="https://t.me/mrtinhios">Liên hệ admin</a>
      </div>
      <div class="telegram">
        Mọi thông tin cần hỗ trợ vui lòng liên hệ<br>
        Telegram: <strong>@mrtinhios</strong>
      </div>
    </div>

    <!-- MENU GIÁ -->
    <div class="menu-container" id="menuContainer">
      <h2>🔐 Bảng Giá Key</h2>
      <div class="menu-list">
        <div class="menu-item">
          <div class="left">📅 1 Ngày</div>
          <div class="right">10.000đ</div>
        </div>
        <div class="menu-item">
          <div class="left">📅 7 Ngày</div>
          <div class="right">50.000đ</div>
        </div>
        <div class="menu-item">
          <div class="left">📅 30 Ngày</div>
          <div class="right">150.000đ</div>
        </div>
        <div class="menu-item">
          <div class="left">📅 Vĩnh Viễn</div>
          <div class="right">350.000đ</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById('toggle-button');
    const menu = document.getElementById('menuContainer');
    let menuOpen = false;

    toggleBtn.addEventListener('click', () => {
      menuOpen = !menuOpen;

      if (menuOpen) {
        menu.classList.add('active');
        toggleBtn.innerHTML = '&#8250;'; // >
      } else {
        menu.classList.remove('active');
        toggleBtn.innerHTML = '&#8249;'; // <
      }
    });
  </script>

</body>
</html>
