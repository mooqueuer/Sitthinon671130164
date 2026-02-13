<?php
session_start();
include('db.php');

if (!isset($_GET['id'])) { die("ไม่พบ ID การประเมิน"); }

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM assessments WHERE id = $id");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <title>รายงานผลการประเมิน - <?php echo $row['username']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; padding: 40px; color: #333; }
        .paper { border: 1px solid #ddd; padding: 40px; max-width: 800px; margin: 0 auto; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h1 { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .info-group { margin-bottom: 20px; font-size: 1.1em; }
        .score-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .score-table th, .score-table td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        .score-table th { background: #f5f5f5; }
        .total-score { font-size: 1.5em; font-weight: bold; text-align: right; margin-top: 20px; color: #333; }
        .footer { margin-top: 60px; text-align: right; }
        
        @media print { 
            .no-print { display: none; } 
            .paper { border: none; box-shadow: none; padding: 0; }
        }
        .btn-print { background: #e74c3c; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; font-size: 1em; }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:center; margin-bottom:20px;">
        <button onclick="window.print()" class="btn-print">🖨️ ปริ้น / บันทึกเป็น PDF</button>
    </div>

    <div class="paper">
        <h1>รายงานผลการประเมินบุคลากร</h1>
        
        <div class="info-group">
            <p><strong>ผู้รับการประเมิน:</strong> <?php echo $row['username']; ?></p>
            <p><strong>วันที่ทำรายการ:</strong> <?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?></p>
        </div>
        
        <table class="score-table">
            <thead>
                <tr>
                    <th width="70%">หัวข้อการประเมิน</th>
                    <th width="30%">คะแนน</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1. ระบบสมัครสมาชิก (Auth)</td><td><?php echo $row['c1_auth']; ?> / 10</td></tr>
                <tr><td>2. บทบาทผู้ใช้ (Role)</td><td><?php echo $row['c2_role']; ?> / 10</td></tr>
                <tr><td>3. ดูผลตนเอง (View Own)</td><td><?php echo $row['c3_own']; ?> / 10</td></tr>
                <tr><td>4. ป้องกันงานซ้ำ (No Dup)</td><td><?php echo $row['c4_dup']; ?> / 10</td></tr>
                <tr><td>5. ความปลอดภัย (IDOR)</td><td><?php echo $row['c5_idor']; ?> / 10</td></tr>
                <tr><td>6. กฎการส่งงาน (Evidence)</td><td><?php echo $row['c6_rule']; ?> / 10</td></tr>
                <tr><td>7. ขนาดไฟล์ (Size Limit)</td><td><?php echo $row['c7_size']; ?> / 10</td></tr>
                <tr><td>8. ชนิดไฟล์ (File Type)</td><td><?php echo $row['c8_type']; ?> / 10</td></tr>
                <tr><td>9. ความสวยงาม (UI/UX)</td><td><?php echo $row['c9_ui']; ?> / 10</td></tr>
                <tr><td>10. ภาพรวม (Overview)</td><td><?php echo $row['c10_com']; ?> / 10</td></tr>
            </tbody>
        </table>

        <div class="total-score">
            คะแนนรวม: <?php echo $row['total_score']; ?> / 100
        </div>

        <div style="margin-top:30px; border:1px solid #ccc; padding:15px; border-radius:5px; background:#f9f9f9;">
            <strong>ความคิดเห็นเพิ่มเติม:</strong><br>
            <?php echo !empty($row['comment']) ? $row['comment'] : "-"; ?>
        </div>

        <div class="footer">
            <p>ลงชื่อ ....................................................... ผู้ประเมิน</p>
            <p>( ....................................................... )</p>
        </div>
    </div>
</body>
</html>