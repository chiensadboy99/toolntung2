<?php
// admin_keys.php — Quản lý Key với giao diện hiện đại công nghệ
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

include 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_key'])) {
        $new_key  = trim($_POST['access_key'] ?? '');
        $key_type = $_POST['key_type'] ?? 'vĩnh viễn';
        $days     = isset($_POST['days']) ? max(0, (int)$_POST['days']) : 0;

        if ($new_key === '') {
            $message = 'error|Vui lòng nhập key!';
        } else {
            try {
                $expires_at = ($key_type === 'gia hạn' && $days > 0) ? date('Y-m-d H:i:s', strtotime("+{$days} days")) : null;
                $stmt = $conn->prepare("INSERT INTO access_keys (access_key, key_type, expires_at) VALUES (?, ?, ?)");
                $stmt->bind_param('sss', $new_key, $key_type, $expires_at);
                $stmt->execute();
                $message = 'success|Tạo key thành công!';
            } catch (mysqli_sql_exception $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $message = 'error|Key đã tồn tại.';
                } else {
                    $message = 'error|Lỗi: ' . $e->getMessage();
                }
            }
        }
    }

    if (isset($_POST['delete_key'])) {
        $id = (int)$_POST['delete_key'];
        $stmt = $conn->prepare('DELETE FROM access_keys WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $message = 'success|Đã xoá key.';
    }

    if (isset($_POST['extend_key'])) {
        $id = (int)$_POST['extend_key'];
        $extend_days = max(0, (int)($_POST['extend_days'] ?? 0));
        if ($extend_days > 0) {
            $stmt = $conn->prepare(
                "UPDATE access_keys SET expires_at = CASE \
                    WHEN expires_at IS NULL OR expires_at < NOW() THEN DATE_ADD(NOW(), INTERVAL ? DAY) \
                    ELSE DATE_ADD(expires_at, INTERVAL ? DAY) END \
                WHERE id = ?"
            );
            $stmt->bind_param('iii', $extend_days, $extend_days, $id);
            $stmt->execute();
            $message = "success|Gia hạn thêm {$extend_days} ngày thành công.";
        } else {
            $message = 'error|Vui lòng nhập số ngày gia hạn.';
        }
    }
}

[$filter, $search] = [(isset($_GET['filter']) ? $_GET['filter'] : 'all'), trim($_GET['q'] ?? '')];
$valid_filters = ['all', 'vĩnh viễn', 'gia hạn'];
if (!in_array($filter, $valid_filters)) $filter = 'all';

$sql = 'SELECT * FROM access_keys WHERE 1';
$params = [];
$types = '';
if ($filter !== 'all') {
    $sql .= ' AND key_type = ?';
    $params[] = $filter;
    $types .= 's';
}
if ($search !== '') {
    $sql .= ' AND access_key LIKE ?';
    $params[] = "%{$search}%";
    $types .= 's';
}
$sql .= ' ORDER BY created_at DESC';
$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$keys = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin TínhiOS - Quản Lý Key</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }
        h2 {
            font-family: 'Orbitron', sans-serif;
            color: #00ffcc;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .form-control, .form-select {
            background-color: #ffffff0d;
            border: 1px solid #00ffcc;
            color: #fff;
        }
        .form-control::placeholder {
            color: #bbb;
        }
        .table {
            color: #fff;
        }
        .table thead {
            background: #00ffcc33;
        }
        .table tbody tr:hover {
            background: #00ffcc11;
        }
        .btn-primary {
            background-color: #00ffcc;
            border: none;
            color: #000;
        }
        .btn-info, .btn-danger, .btn-secondary {
            border: none;
        }
        .badge-success {
            background-color: #10b981;
        }
        .badge-warning {
            background-color: #f59e0b;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="text-center mb-5">
        <h2>🔐 Admin TínhiOS - Quản Lý Key</h2>
    </div>

    <div class="card shadow mb-4 p-4">
        <form method="post" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="access_key" class="form-control" placeholder="Nhập key cần tạo" required>
            </div>
            <div class="col-md-3">
                <select name="key_type" id="key_type" class="form-select" onchange="toggleDaysInput()">
                    <option value="vĩnh viễn">🔒 Vĩnh viễn</option>
                    <option value="gia hạn">⏳ Gia hạn</option>
                </select>
            </div>
            <div class="col-md-2" id="days_input" style="display:none">
                <input type="number" name="days" class="form-control" placeholder="Số ngày" min="1">
            </div>
            <div class="col-md-3">
                <button type="submit" name="create_key" class="btn btn-primary w-100">Tạo Key</button>
            </div>
        </form>
    </div>

    <form method="get" class="row gy-2 gx-2 align-items-center mb-4">
        <div class="col-auto">
            <select name="filter" class="form-select">
                <option value="all" <?= $filter==='all'?'selected':''?>>Tất cả</option>
                <option value="vĩnh viễn" <?= $filter==='vĩnh viễn'?'selected':''?>>Vĩnh viễn</option>
                <option value="gia hạn" <?= $filter==='gia hạn'?'selected':''?>>Gia hạn</option>
            </select>
        </div>
        <div class="col-auto">
            <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($search) ?>" placeholder="Tìm key...">
        </div>
        <div class="col-auto">
            <button class="btn btn-secondary">Lọc</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Loại</th>
                    <th>Ngày tạo</th>
                    <th>Hết hạn</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $keys->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['access_key']) ?></td>
                    <td><span class="badge bg-<?= $row['key_type']==='vĩnh viễn' ? 'success' : 'warning' ?>"><?= ucfirst($row['key_type']) ?></span></td>
                    <td><?= $row['created_at'] ?></td>
                    <td><?= $row['key_type']==='gia hạn' ? ($row['expires_at'] ?? '-') : 'Không hết hạn' ?></td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="delete_key" value="<?= $row['id'] ?>">
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xoá key?')">Xoá</button>
                        </form>
                        <?php if ($row['key_type']==='gia hạn'): ?>
                        <form method="post" class="d-inline d-flex align-items-center mt-1">
                            <input type="number" name="extend_days" placeholder="Ngày" min="1" class="form-control form-control-sm me-2" style="width:80px">
                            <input type="hidden" name="extend_key" value="<?= $row['id'] ?>">
                            <button class="btn btn-info btn-sm">Gia hạn</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if ($message !== ''): ?>
<script>
    const [icon, msg] = "<?= $message ?>".split('|');
    Swal.fire({ icon, title: msg, timer: 2200, showConfirmButton: false });
</script>
<?php endif; ?>
<script>
    function toggleDaysInput() {
        const type = document.getElementById("key_type").value;
        document.getElementById("days_input").style.display = type === "gia hạn" ? "block" : "none";
    }
    toggleDaysInput();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>