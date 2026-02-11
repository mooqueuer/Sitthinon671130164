<?php 
session_start();
include('db.php');
// ตรวจสอบสิทธิ์: ต้องล็อกอิน และต้องเป็น admin
if (!isset($_SESSION['username']) || (isset($_SESSION['role']) && $_SESSION['role'] != 'admin')) { 
    header("location: login.html"); exit(); 
}

// ลบผู้ใช้
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("location: manage_users.php");
}

$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการผู้ใช้งาน</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fas fa-users-cog"></i> จัดการผู้ใช้</div>
        <div class="menu">
            <a href="admin_dashboard.php">กลับหน้าหลัก</a>
        </div>
    </nav>

    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3>รายชื่อผู้ใช้งานทั้งหมด</h3>
            <a href="register.html" style="background:#00ff88; color:black; padding:10px 20px; border-radius:5px; text-decoration:none; font-weight:bold;">+ เพิ่มผู้ใช้</a>
        </div>

        <div class="card" style="padding:0; overflow:hidden;">
            <table>
                <thead>
                    <tr>
                        <th style="padding-left:20px;">ชื่อผู้ใช้</th>
                        <th>บทบาท (Role)</th>
                        <th style="text-align:center;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td style="padding-left:20px;">
                            <div style="font-weight:bold; font-size:1.1rem;"><?php echo $row['username']; ?></div>
                            <small style="color:#aaa;"><?php echo $row['email']; ?></small>
                        </td>
                        
                        <td>
                            <?php 
                            $r = $row['role'];
                            $cls = ($r=='admin')?'role-admin':(($r=='evaluator')?'role-evaluator':'role-student');
                            ?>
                            <span class="badge <?php echo $cls; ?>"><?php echo ucfirst($r); ?></span>
                        </td>
                        
                        <td style="text-align:center;">
                            <a href="manage_users.php?del=<?php echo $row['id']; ?>" class="btn-small btn-red" onclick="return confirm('ยืนยันลบ?');">ลบ</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>