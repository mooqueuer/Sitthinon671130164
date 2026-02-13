<?php 
session_start();
// ตรวจสอบสิทธิ์ (Admin/Evaluator เท่านั้น)
if (!isset($_SESSION['username']) || $_SESSION['role'] == 'student') { 
    header("location: login.html"); exit(); 
}

// รับชื่อคนที่จะประเมิน
$target_user = isset($_GET['target_user']) ? $_GET['target_user'] : '';
if ($target_user == '') { header("location: assessment_list.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แบบประเมิน - <?php echo $target_user; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fas fa-pen-nib"></i> ประเมินผล</div>
        <div class="menu"><a href="assessment_list.php">ย้อนกลับ</a></div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 style="margin-bottom:20px; color:#45f3ff;">
                ประเมินคุณ: <span style="color:#fff;"><?php echo $target_user; ?></span>
            </h2>

            <form action="assessment_db.php" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="target_user" value="<?php echo $target_user; ?>">

                <h4 style="color:#00b894; margin:15px 0;">1. Functional Test</h4>
                <div class="score-group"><label>1. ระบบสมัครสมาชิก/ล็อกอิน</label><input type="number" name="c1" min="0" max="10" required></div>
                <div class="score-group"><label>2. หน้า Home แยกบทบาท</label><input type="number" name="c2" min="0" max="10" required></div>
                <div class="score-group"><label>3. ดูผลเฉพาะตนเอง</label><input type="number" name="c3" min="0" max="10" required></div>
                <div class="score-group"><label>4. ป้องกันงานซ้ำ</label><input type="number" name="c4" min="0" max="10" required></div>

                <h4 style="color:#00b894; margin:15px 0;">2. Security Test</h4>
                <div class="score-group"><label>5. ป้องกัน IDOR</label><input type="number" name="c5" min="0" max="10" required></div>
                <div class="score-group"><label>6. Evidence Rule</label><input type="number" name="c6" min="0" max="10" required></div>

                <h4 style="color:#00b894; margin:15px 0;">3. Non-Functional</h4>
                <div class="score-group"><label>7. ป้องกันไฟล์เกิน 10MB</label><input type="number" name="c7" min="0" max="10" required></div>
                <div class="score-group"><label>8. ชนิดไฟล์ต้องห้าม</label><input type="number" name="c8" min="0" max="10" required></div>

                <h4 style="color:#00b894; margin:15px 0;">4. Overview</h4>
                <div class="score-group"><label>9. UX/UI</label><input type="number" name="c9" min="0" max="10" required></div>
                <div class="score-group"><label>10. ภาพรวมเว็บไซต์</label><input type="number" name="c10" min="0" max="10" required></div>

                <hr style="margin:20px 0; border-color:#555;">

                <label>แนบไฟล์หลักฐาน (ไม่เกิน 10MB):</label>
                <input type="file" name="evidence" accept=".pdf,.jpg,.png" style="margin-bottom:15px;">

                <label>ความคิดเห็น:</label>
                <textarea name="comment" rows="3" style="width:100%; margin-bottom:15px; background:rgba(0,0,0,0.3); color:white; border:1px solid #555;"></textarea>

                <button type="submit" name="submit_assessment" style="background:#00b894; color:white; font-weight:bold; padding:15px; width:100%; border:none; border-radius:5px; cursor:pointer;">บันทึกผลการประเมิน</button>
            </form>
        </div>
    </div>
    
    <style>
        .score-group { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .score-group input { width: 60px; text-align: center; }
    </style>
</body>
</html>