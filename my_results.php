<?php 
session_start();
include('db.php');
if (!isset($_SESSION['username'])) { header("location: login.html"); exit(); }

$me = $_SESSION['username'];
// ดึงข้อมูลที่ target_user ตรงกับชื่อเรา
$result = $conn->query("SELECT * FROM assessments WHERE target_user = '$me' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ผลการประเมินของฉัน</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fas fa-file-alt"></i> ผลการประเมินของฉัน</div>
        <div class="menu"><a href="member.php">กลับหน้าหลัก</a></div>
    </nav>

    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="card" style="margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h3><i class="fas fa-check-circle" style="color:#00ff88;"></i> ได้รับการประเมินจาก: <?php echo $row['evaluator_name']; ?></h3>
                    <div style="font-size:1.5em; font-weight:bold; color:#45f3ff;"><?php echo $row['total_score']; ?> / 100 คะแนน</div>
                </div>
                <hr style="border-color:rgba(255,255,255,0.1); margin:15px 0;">
                <p><strong>ความเห็น:</strong> <?php echo $row['comment'] ? $row['comment'] : "-"; ?></p>
                <p><small style="color:#aaa;">เมื่อ: <?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></small></p>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="card" style="text-align:center; padding:50px;">
                <i class="fas fa-box-open" style="font-size:50px; color:#555;"></i>
                <p style="margin-top:20px;">ยังไม่มีผลการประเมินของคุณในขณะนี้</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>