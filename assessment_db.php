<?php
session_start();
include('db.php');

if (isset($_POST['submit_assessment'])) {
    // ป้องกัน Student แอบส่งข้อมูลเข้ามา
    if ($_SESSION['role'] == 'student') { header("location: member.php"); exit(); }

    $evaluator = $_SESSION['username'];
    $target = $_POST['target_user'];

    // รับคะแนน
    $c1 = $_POST['c1']; $c2 = $_POST['c2']; $c3 = $_POST['c3']; $c4 = $_POST['c4'];
    $c5 = $_POST['c5']; $c6 = $_POST['c6']; $c7 = $_POST['c7']; $c8 = $_POST['c8'];
    $c9 = $_POST['c9']; $c10 = $_POST['c10'];
    
    $total = $c1 + $c2 + $c3 + $c4 + $c5 + $c6 + $c7 + $c8 + $c9 + $c10;

    // จัดการไฟล์แนบ (เช็ค 10MB = 10485760 bytes)
    $file_name = "";
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] == 0) {
        if ($_FILES['evidence']['size'] > 10485760) {
            echo "<script>alert('ไฟล์มีขนาดเกิน 10MB!'); window.history.back();</script>";
            exit();
        }
        // เปลี่ยนชื่อไฟล์ป้องกันซ้ำ
        $ext = pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_evidence." . $ext;
        
        // สร้างโฟลเดอร์ uploads ถ้ายังไม่มี
        if (!file_exists('uploads')) { mkdir('uploads', 0777, true); }
        
        move_uploaded_file($_FILES['evidence']['tmp_name'], "uploads/" . $file_name);
    }

    // บันทึกลงฐานข้อมูล
    $sql = "INSERT INTO assessments (evaluator_name, target_user, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, total_score, evidence_file) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiiiiiiiiis", $evaluator, $target, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $total, $file_name);

    if ($stmt->execute()) {
        $alert_msg = "บันทึกผลสำเร็จ! คะแนนรวม: $total/100";
        
        // เช็คว่าติ๊กส่งเมลไหม
        if (isset($_POST['send_email'])) {
            $alert_msg .= "\\n(ระบบจำลอง: ส่งอีเมลแจ้งเตือนไปยัง $target เรียบร้อยแล้ว)";
        }

        echo "<script>alert('$alert_msg'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>