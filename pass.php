<?php
$plain = 'tinhios123@'; // Thay đổi mật khẩu ở đây
$hash = password_hash($plain, PASSWORD_DEFAULT);

echo "🔐 Mật khẩu gốc: $plain<br>";
echo "🧊 Mã hóa: <input style='width:100%' value='$hash'>";
?>
