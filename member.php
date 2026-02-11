<?php 
session_start();
if (!isset($_SESSION['username'])) { header("location: login.html"); exit(); }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="brand"><i class="fas fa-user-circle"></i> สมาชิกทั่วไป</div>
        <div class="menu">
            <span>สวัสดี, <?php echo $_SESSION['username']; ?></span>
            <a href="login.html" class="btn-logout">ออกจากระบบ</a>
        </div>
    </nav>

    <div class="container">
        <div class="card hero">
            <div class="hero-icon">🎉</div>
            <div>
                <h2>ยินดีต้อนรับ!</h2>
                <p>สถานะของคุณคือ: <strong><?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Member'; ?></strong></p>
            </div>
        </div>

        <div class="grid-menu">
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'evaluator'): ?>
            <a href="assessment_list.php" class="menu-card" style="border-left:3px solid #f1c40f;">
                <i class="fas fa-pen-nib c-yellow"></i>
                <div>
                    <h3>ทำแบบประเมิน</h3>
                    <p>ประเมินนักศึกษาในความดูแล</p>
                </div>
            </a>
            <?php endif; ?>

            <a href="my_results.php" class="menu-card" style="border-left:3px solid #45f3ff;">
    <i class="fas fa-file-alt c-blue"></i>
    <div>
        <h3>ผลการประเมินของฉัน</h3>
        <p>ดูคะแนนที่ได้รับ</p>
    </div>
</a>

<a href="edit_profile.php" class="menu-card" style="border-left:3px solid #00ff88;">
    <i class="fas fa-user-edit c-green"></i>
    <div>
        <h3>แก้ไขข้อมูลส่วนตัว</h3>
        <p>จัดการข้อมูลบัญชีผู้ใช้</p>
    </div>
</a>
        </div>
    </div>

</body>
</html>