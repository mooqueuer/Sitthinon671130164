<?php 
session_start();
include('db.php');
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') { header("location: login.html"); exit(); }
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
            <span style="margin-right:15px;">สวัสดี, <?php echo $_SESSION['username']; ?></span>
            <a href="login.html" class="btn-logout">ออกระบบ</a>
        </div>
    </nav>

    <div class="container">
        <div class="card hero">
            <div class="hero-icon">👋</div>
            <div>
                <h2>ยินดีต้อนรับ ผู้ดูแลระบบ</h2>
                <p>เลือกเมนูที่ต้องการจัดการด้านล่าง</p>
            </div>
        </div>

        <h3 style="margin-bottom:20px; color:#45f3ff;">เมนูการจัดการ</h3>
        <div class="grid-menu">
            <a href="manage_users.php" class="menu-card" style="border-left:3px solid #a29bfe;">
                <i class="fas fa-users c-purple"></i>
                <div>
                    <h3>จัดการผู้ใช้งาน</h3>
                    <p>เพิ่ม ลบ แก้ไข ข้อมูลผู้ใช้</p>
                </div>
            </a>
            
            <a href="#" class="menu-card" style="border-left:3px solid #ff7675;">
                <i class="fas fa-cogs c-pink"></i>
                <div>
                    <h3>ตั้งค่าระบบ</h3>
                    <p>กำหนดค่าพื้นฐานเว็บไซต์</p>
                </div>
            </a>

            <a href="#" class="menu-card" style="border-left:3px solid #ffeaa7;">
                <i class="fas fa-chart-pie c-yellow"></i>
                <div>
                    <h3>รายงานผล</h3>
                    <p>ดูสถิติการประเมิน</p>
                </div>
            </a>

            <a href="#" class="menu-card" style="border-left:3px solid #55efc4;">
                <i class="fas fa-clipboard-check c-green"></i>
                <div>
                    <h3>การประเมิน</h3>
                    <p>ทำแบบประเมินบุคลากร</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>