<?php 
session_start();
// 1. เช็คสิทธิ์: ถ้าเป็น Student ให้เด้งกลับไปหน้า Member ทันที (เข้าไม่ได้)
if (!isset($_SESSION['username']) || $_SESSION['role'] == 'student') { 
    echo "<script>alert('นักศึกษาไม่สามารถเข้าถึงหน้าประเมินได้ (ทำได้เพียงดูผลการประเมิน)'); window.location='member.php';</script>";
    exit(); 
}

$target_user = isset($_GET['target_user']) ? $_GET['target_user'] : 'ไม่ระบุ';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แบบประเมินผลงาน (Evaluator Only)</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .score-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .score-input { width: 70px; text-align: center; }
        .btn-pdf { background: #e74c3c; color: white; padding: 5px 15px; border-radius: 5px; cursor: pointer; float: right; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="brand"><i class="fas fa-pen-nib"></i> ส่วนประเมินผล</div>
        <div class="menu"><a href="assessment_list.php">ย้อนกลับ</a></div>
    </nav>

    <div class="container">
        <div class="card">
            <div style="overflow: hidden; margin-bottom: 20px;">
                <h2 style="float: left;">ประเมิน: <span style="color:#45f3ff;"><?php echo $target_user; ?></span></h2>
                <button onclick="window.print()" class="btn-pdf"><i class="fas fa-file-pdf"></i> Save as PDF</button>
            </div>

            <form action="assessment_db.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="target_user" value="<?php echo $target_user; ?>">

                <h4 style="color:#45f3ff; margin: 20px 0;">1. Functional Test (40 คะแนน)</h4>
                <div class="score-row"><label>1. ระบบสมัครสมาชิก/ล็อกอิน</label><input type="number" name="c1" class="score-input" min="0" max="10" required></div>
                <div class="score-row"><label>2. หน้า Home แยกบทบาทถูกต้อง</label><input type="number" name="c2" class="score-input" min="0" max="10" required></div>
                <div class="score-row"><label>3. ดูผลลัพธ์เฉพาะของตนเอง</label><input type="number" name="c3" class="score-input" min="0" max="10" required></div>
                <div class="score-row"><label>4. ป้องกันการมอบหมายงานซ้ำ</label><input type="number" name="c4" class="score-input" min="0" max="10" required></div>

                <h4 style="color:#45f3ff; margin: 20px 0;">2. Security Test (20 คะแนน)</h4>
                <div class="score-row"><label>5. ป้องกัน IDOR (เข้าถึงข้อมูลคนอื่น)</label><input type="number" name="c5" class="score-input" min="0" max="10" required></div>
                <div class="score-row"><label>6. Evidence Rule (กฎการส่งงาน)</label><input type="number" name="c6" class="score-input" min="0" max="10" required></div>

                <h4 style="color:#45f3ff; margin: 20px 0;">3. Non-Functional (20 คะแนน)</h4>
                <div class="score-row"><label>7. ป้องกันไฟล์เกิน 10MB</label><input type="number" name="c7" class="score-input" min="0" max="10" required></div>
                <div class="score-row"><label>8. ป้องกันไฟล์ต้องห้าม (.exe)</label><input type="number" name="c8" class="score-input" min="0" max="10" required></div>

                <h4 style="color:#45f3ff; margin: 20px 0;">4. Overview (20 คะแนน)</h4>
                <div class="score-row"><label>9. ความสวยงามของ UX/UI</label><input type="number" name="c9" class="score-input" min="0" max="10" required></div>
                <div class="score-row"><label>10. ภาพรวมของเว็บไซต์</label><input type="number" name="c10" class="score-input" min="0" max="10" required></div>

                <hr style="margin: 20px 0; border-color: rgba(255,255,255,0.1);">

                <div style="margin-bottom: 15px;">
                    <label>แนบไฟล์หลักฐาน (ไม่เกิน 10MB):</label><br>
                    <input type="file" name="evidence" accept=".pdf,.jpg,.png">
                </div>

                <div style="margin-bottom: 20px;">
                    <input type="checkbox" name="send_email" id="mail" value="1">
                    <label for="mail">ส่งผลการประเมินแจ้งเตือนทางอีเมล</label>
                </div>

                <button type="submit" name="submit_assessment">บันทึกผลการประเมิน</button>
            </form>
        </div>
    </div>
</body>
</html>