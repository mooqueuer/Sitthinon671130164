<?php 
session_start();
// ตรวจสอบสิทธิ์ Admin
if (!isset($_SESSION['username']) || (isset($_SESSION['role']) && $_SESSION['role'] != 'admin')) { 
    if(isset($_SESSION['username'])) { header("location: member.php"); exit(); }
    header("location: login.html"); exit(); 
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fas fa-rocket"></i> ADMIN CONSOLE</div>
        <div class="menu">
            <span>Admin: <?php echo $_SESSION['username']; ?></span>
            <a href="login.html" class="btn-logout">ออกระบบ</a>
        </div>
    </nav>

    <div class="container">
        <div class="card hero">
            <div class="hero-icon">🛡️</div>
            <div>
                <h2>แผงควบคุมผู้ดูแลระบบ</h2>
                <p>จัดการข้อมูลผู้ใช้และระบบประเมิน</p>
            </div>
        </div>

        <div class="grid-menu">
            <a href="manage_users.php" class="menu-card" style="border-left:3px solid #a29bfe;">
                <i class="fas fa-users-cog c-purple"></i>
                <div>
                    <h3>จัดการผู้ใช้งาน</h3>
                    <p>เพิ่ม/ลบ/แก้ไข สมาชิก</p>
                </div>
            </a>
            
            <a href="assessment_list.php" class="menu-card" style="border-left:3px solid #00b894;">
                <i class="fas fa-clipboard-check c-green"></i>
                <div>
                    <h3>ระบบประเมิน</h3>
                    <p>ประเมินบุคลากร/นักศึกษา</p>
                </div>
            </a>

            <a href="report_dashboard.php" class="menu-card" style="border-left:3px solid #ff7675;">
    <i class="fas fa-chart-line c-pink"></i>
    <div>
        <h3>รายงานสรุป</h3>
        <p>ดูสถิติภาพรวมระบบ</p>
    </div>
</a>
        </div>
    </div>
</body>
</html>