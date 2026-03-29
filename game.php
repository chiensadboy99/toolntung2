<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="HandheldFriendly" content="true">
  <title>MrTínhiOS - Tool Game Tài Xỉu Uy Tín</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #6366f1;
      --secondary-color: #8b5cf6;
      --accent-color: #a78bfa;
      --light-color: rgba(255, 255, 255, 0.9);
      --dark-color: #1e293b;
      --success-color: #10b981;
      --error-color: #ef4444;
      --warning-color: #f59e0b;
      --glass-blur: 10px;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      -webkit-tap-highlight-color: transparent;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background: url('https://tooltxthanhtung.site/IMAGE/anh-nen-may-tinh-4k-chill_48991223469.jpg') no-repeat center center fixed;
      background-size: cover;
      background-position: center;
      min-height: 100vh;
      padding: 15px;
      position: relative;
      color: white;
      touch-action: manipulation;
    }
    
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.3), rgba(139, 92, 246, 0.3));
      z-index: 0;
    }

    #gameMenu {
      display: block;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('https://tooltxthanhtung.site/IMAGE/anh-nen-may-tinh-4k-chill_48991223469.jpg') no-repeat center center;
      background-size: cover;
      z-index: 1001;
      padding: 20px;
      overflow-y: auto;
    }

    #gameMenu::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      z-index: -1;
    }

    .game-menu-container {
      max-width: 600px;
      margin: 0 auto;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .welcome-message {
      text-align: center;
      margin-bottom: 30px;
      padding: 20px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .welcome-message h2 {
      font-size: 24px;
      color: white;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .welcome-message h3 {
      font-size: 20px;
      color: var(--accent-color);
      margin-bottom: 5px;
      font-weight: 500;
    }

    .welcome-message p {
      color: rgba(255, 255, 255, 0.8);
      font-size: 14px;
    }

    .game-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin-bottom: 30px;
    }

    .game-card {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: all 0.3s ease;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .game-card:hover {
      transform: translateY(-5px);
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .game-card .game-logo {
      width: 80px;
      height: 80px;
      object-fit: contain;
      margin: 0 auto 15px;
      display: block;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .game-card .game-name {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 5px;
      color: white;
    }

    .game-card .game-desc {
      font-size: 13px;
      color: rgba(255, 255, 255, 0.7);
    }

    .maintenance-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      color: white;
      z-index: 2;
    }

    .alert-box {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(255, 255, 255, 0.95);
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
      z-index: 1000;
      display: flex;
      align-items: center;
      max-width: 90%;
      color: var(--dark-color);
      font-size: 14px;
      animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translate(-50%, -20px);
      }
      to {
        opacity: 1;
        transform: translate(-50%, 0);
      }
    }
    
    .alert-box i {
      margin-right: 10px;
      font-size: 18px;
    }

    .alert-box.success {
      background: rgba(16, 185, 129, 0.9);
      color: white;
    }

    .alert-box.error {
      background: rgba(239, 68, 68, 0.9);
      color: white;
    }

    .alert-box.warning {
      background: rgba(245, 158, 11, 0.9);
      color: white;
    }

    #iframeGame {
      display: none; 
      width: 100vw; 
      height: 100vh; 
      border: none;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
    }

    #robotContainer {
      position: fixed;
      top: 50%;
      left: 30px;
      transform: translateY(-50%);
      display: none;
      z-index: 9999;
    }
    
    #robotInner {
      display: flex;
      align-items: center;
      transform: rotate(90deg);
      transform-origin: left center;
    }
    
    #robotIcon {
      width: 120px;
      height: 120px;
      margin-right: 12px;
      pointer-events: none;
    }
    
    #robotText {
      background: #fff;
      color: #000;
      padding: 10px 14px;
      border-radius: 12px;
      font-size: 16px;
      line-height: 1.5;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
      white-space: nowrap;
      max-width: 280px;
      position: relative;
    }

    @media (max-width: 480px) {
      .welcome-message h2 {
        font-size: 20px;
      }

      .welcome-message h3 {
        font-size: 18px;
      }

      .game-grid {
        grid-template-columns: 1fr;
      }

      #robotContainer {
        left: 10px;
      }
      
      #robotIcon {
        width: 100px;
        height: 100px;
      }
      
      #robotText {
        font-size: 14px;
        padding: 8px 12px;
        max-width: 200px;
      }
    }

    @supports (-webkit-touch-callout: none) {
      input, textarea, select {
        font-size: 16px !important;
      }
      
      input:focus, textarea:focus {
        font-size: 16px !important;
      }
    }

    html {
      touch-action: manipulation;
    }
  </style>
</head>
<body>
  <div id="gameMenu">
    <div class="game-menu-container">
      <div class="welcome-message">
        <h2>Chào Mừng Bạn Đến Với Tool</h2>
        <h3>TOOL TX by MrTínhiOS</h3>
        <p>Chọn game bạn muốn chơi</p>
      </div>
      <div class="game-grid">
        <div class="game-card" onclick="selectGame('sunwin')">
          <img src="https://i.postimg.cc/YCxMC5kQ/CDF2-EA1-E-C8-BA-4-EEB-922-D-365-A330-F8995.jpg" class="game-logo" alt="Sunwin">
          <div class="game-name">SUNWIN</div>
          <div class="game-desc">ROBOT Dự đoán Tài Xỉu</div>
        </div>
        <div class="game-card" onclick="selectGame('789club')">
          <img src="https://raw.githubusercontent.com/csgopravo/csgopravo.github.io/main/789-logo.png" class="game-logo" alt="789Club">
          <div class="game-name">789CLUB</div>
          <div class="game-desc">ROBOT Dự đoán Tài Xỉu</div>
        </div>
        <div class="game-card" onclick="selectGame('xocdia88')">
          <img src="https://cdn-icons-png.flaticon.com/512/2694/2694925.png" class="game-logo" alt="Xocdia88">
          <div class="game-name">XOCDIA88</div>
          <div class="game-desc">Sẽ sớm cập nhật</div>
          <div class="maintenance-overlay">BẢO TRÌ</div>
        </div>
        <div class="game-card" onclick="selectGame('68gb')">
          <img src="https://cdn-icons-png.flaticon.com/512/3767/3767084.png" class="game-logo" alt="68GB">
          <div class="game-name">68GB</div>
          <div class="game-desc">Sẽ sớm cập nhật</div>
          <div class="maintenance-overlay">BẢO TRÌ</div>
        </div>
      </div>
    </div>
  </div>

  <div id="robotContainer">
    <div id="robotInner">
      <img id="robotIcon" src="https://iqai.com/_next/image?url=/gifs/home/robotics.gif&w=828&q=75" alt="Robot Icon" />
      <div id="robotText">
        <div id="line1"><strong>Đang tải...</strong></div>
        <div id="line2"></div>
      </div>
    </div>
  </div>

  <iframe id="iframeGame" src=""></iframe>

  <script>
    // Game Config
    const gameConfig = {
      sunwin: {
        url: "https://web.sun.win",
        api: "https://proxysun.onrender.com/api/sunwin",
        icon: "https://iqai.com/_next/image?url=/gifs/home/robotics.gif&w=828&q=75",
        available: true
      },
      '789club': {
        url: "https://play.789.club",
        api: "https://proxy-n-api.onrender.com/api/789club",
        icon: "https://iqai.com/_next/image?url=/gifs/home/robotics.gif&w=828&q=75",
        available: true
      },
      xocdia88: {
        url: "https://play.xoc88.info",
        api: "http://000.000.000.000:0000",
        icon: "https://iqai.com/_next/image?url=/gifs/home/robotics.gif&w=828&q=75",
        available: false,
        maintenance: true
      },
      '68gb': {
        url: "https://68gamebai.club",
        api: "http://160.191.243.121:6000/api/68gb?key=tinhdeptrai",
        icon: "https://iqai.com/_next/image?url=/gifs/home/robotics.gif&w=828&q=75",
        available: false,
        maintenance: true
      }
    };

    // Robot elements
    const robotContainer = document.getElementById("robotContainer");
    const iframe = document.getElementById("iframeGame");
    const gameMenu = document.getElementById("gameMenu");
    let lastPhien = null;
    let lastPhienTime = 0;

    // Hiển thị thông báo
    function showAlert(message, type = 'error') {
      const alertBox = document.createElement('div');
      alertBox.className = `alert-box ${type}`;
      alertBox.innerHTML = `
        <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'}"></i>
        <span>${message}</span>
      `;
      
      document.body.appendChild(alertBox);
      
      setTimeout(() => {
        alertBox.style.opacity = '0';
        setTimeout(() => alertBox.remove(), 300);
      }, 3000);
    }

    // Drag robot container
    let isRobotDragging = false, robotOffsetX = 0, robotOffsetY = 0;
    robotContainer.addEventListener("mousedown", e => {
      isRobotDragging = true;
      robotOffsetX = e.clientX - robotContainer.offsetLeft;
      robotOffsetY = e.clientY - robotContainer.offsetTop;
      e.preventDefault();
    });
    document.addEventListener("mousemove", e => {
      if (isRobotDragging) {
        robotContainer.style.left = (e.clientX - robotOffsetX) + "px";
        robotContainer.style.top = (e.clientY - robotOffsetY) + "px";
      }
    });
    document.addEventListener("mouseup", () => isRobotDragging = false);

    robotContainer.addEventListener("touchstart", e => {
      isRobotDragging = true;
      const touch = e.touches[0];
      robotOffsetX = touch.clientX - robotContainer.offsetLeft;
      robotOffsetY = touch.clientY - robotContainer.offsetTop;
      e.preventDefault();
    });
    document.addEventListener("touchmove", e => {
      if (isRobotDragging) {
        const touch = e.touches[0];
        robotContainer.style.left = (touch.clientX - robotOffsetX) + "px";
        robotContainer.style.top = (touch.clientY - robotOffsetY) + "px";
      }
    });
    document.addEventListener("touchend", () => isRobotDragging = false);

    // Select game function
    function selectGame(game) {
      if (gameConfig[game]?.maintenance) {
        showAlert("Game đang bảo trì. Vui lòng chọn game khác!", 'warning');
        return;
      }
      
      if (!gameConfig[game]?.available) {
        showAlert("Game tạm thời không khả dụng!", 'error');
        return;
      }

      currentGame = game;
      gameMenu.style.display = 'none';
      iframe.src = gameConfig[game].url;
      iframe.style.display = 'block';
      robotContainer.style.display = 'block';
      document.getElementById("robotIcon").src = gameConfig[game].icon;
      startPrediction();
    }

    // Prediction function
    async function startPrediction() {
      if (!currentGame) return;
      
      async function fetchData() {
        try {
          const res = await fetch(gameConfig[currentGame].api);
          const data = await res.json();

          const phien = data.phien_hien_tai || data.session || "...";
          const duDoan = data.du_doan || data.prediction || "...";
          const tile = Math.round(parseFloat(data.do_tin_cay || data.confidence)) || "...";

          if (phien !== lastPhien) {
            lastPhien = phien;
            lastPhienTime = Date.now();
          }

          const delay = Date.now() - lastPhienTime;
          if (delay < 25000) {
            document.getElementById("line1").innerHTML = "<strong>Chờ phiên mới</strong>";
            document.getElementById("line2").innerHTML = "";
            return;
          }

          document.getElementById("line1").innerHTML = `#${phien}: <strong>${duDoan}</strong>`;
          document.getElementById("line2").innerHTML = `Độ tin cậy: <strong>${tile}%</strong>`;
        } catch (err) {
          document.getElementById("line1").innerHTML = "<strong>Lỗi kết nối</strong>";
          document.getElementById("line2").innerHTML = "";
        }
      }

      fetchData();
      setInterval(fetchData, 2000);
    }

    // Ngăn zoom không mong muốn trên mobile
    document.addEventListener('dblclick', function(e) {
      e.preventDefault();
    }, { passive: false });

    // Ngăn zoom khi focus vào input trên iOS
    document.addEventListener('touchstart', function(e) {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
        document.body.style.zoom = "1.0";
      }
    }, { passive: true });
  </script>
</body>
</html>
