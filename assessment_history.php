<?php 
session_start();
include('db.php');

// 1. ตรวจสอบล็อกอิน
if (!isset($_SESSION['username'])) { 
    header("location: login.html"); 
    exit(); 
}

// 2. กำหนดว่าเราจะดูประวัติของใคร?
if ($_SESSION['role'] == 'student') {
    // ถ้านักศึกษาล็อคอิน -> ดูของตัวเอง
    $target_user = $_SESSION['username'];
} else {
    // ถ้า Admin/Evaluator -> ดูของคนที่เราเลือกส่งมา
    $target_user = isset($_GET['target_user']) ? $_GET['target_user'] : '';
    
    // ถ้าไม่มีชื่อส่งมา ให้กลับไปหน้ารายชื่อ
    if ($target_user == '') { 
        header("location: assessment_list.php"); 
        exit(); 
    }
}

// 3. ดึงข้อมูล (จุดที่แก้ไข: ใช้ target_user แทน username)
$sql = "SELECT * FROM assessments WHERE target_user = '$target_user' ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการประเมิน - <?php echo $target_user; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="brand"><i class="fas fa-history"></i> ประวัติการประเมิน</div>
        <div class="menu">
            <?php if($_SESSION['role'] == 'student'): ?>
                <a href="member.php">กลับหน้าหลัก</a>
            <?php else: ?>
                <a href="assessment_list.php">ย้อนกลับ</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2>ผลการประเมินของ: <span style="color:#45f3ff;"><?php echo $target_user; ?></span></h2>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="grid-menu"> <?php while($row = $result->fetch_assoc()): ?>
                <div class="menu-card" style="min-height:auto; display:block;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-size:1.2em; font-weight:bold; color:#fff; margin-bottom:5px;">
                                <i class="fas fa-calendar-alt"></i> <?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?>
                            </div>
                            <div style="color:#aaa;">
                                คะแนนรวม: <strong style="color:#00b894; font-size:1.2em;"><?php echo $row['total_score']; ?>/100</strong>
                            </div>
                        </div>
                        
                        <a href="report_pdf.php?id=<?php echo $row['id']; ?>" target="_blank" 
                           style="background:#e74c3c; color:white; padding:10px 15px; border-radius:8px; text-decoration:none; font-weight:bold;">
                           <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="card" style="text-align:center; padding:50px;">
                <i class="fas fa-folder-open" style="font-size:50px; color:#555;"></i>
                <p style="margin-top:20px; color:#aaa;">ยังไม่มีประวัติการประเมิน</p>
                
                <?php if($_SESSION['role'] != 'student'): ?>
                    <a href="assessment_form.php?target_user=<?php echo $target_user; ?>" 
                       style="display:inline-block; margin-top:15px; background:#00b894; color:white; padding:10px 20px; border-radius:5px; text-decoration:none;">
                       เริ่มประเมินเลย
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>