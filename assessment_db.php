<?php
session_start();
include('db.php');

if (isset($_POST['submit_assessment'])) {
    
    // 1. รับค่าตัวแปร
    $evaluator = $_SESSION['username'];       // คนประเมิน (Admin)
    $target = $_POST['target_user'];          // คนถูกประเมิน (เช่น Kew)
    
    // คะแนน 10 ข้อ
    $c1 = $_POST['c1']; $c2 = $_POST['c2']; $c3 = $_POST['c3']; $c4 = $_POST['c4'];
    $c5 = $_POST['c5']; $c6 = $_POST['c6']; $c7 = $_POST['c7']; $c8 = $_POST['c8'];
    $c9 = $_POST['c9']; $c10 = $_POST['c10'];
    
    $total = $c1 + $c2 + $c3 + $c4 + $c5 + $c6 + $c7 + $c8 + $c9 + $c10;
    $comment = $_POST['comment'];

    // 2. จัดการไฟล์แนบ
    $file_name = "";
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] == 0) {
        if ($_FILES['evidence']['size'] > 10 * 1024 * 1024) { // 10MB
            echo "<script>alert('ไฟล์เกิน 10MB!'); window.history.back();</script>";
            exit();
        }
        // สร้างโฟลเดอร์ถ้าไม่มี
        if (!file_exists('uploads')) { mkdir('uploads', 0777, true); }
        
        $ext = pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_evidence." . $ext;
        move_uploaded_file($_FILES['evidence']['tmp_name'], "uploads/" . $file_name);
    }

    // 3. บันทึกลงฐานข้อมูล (ให้ตรงกับตาราง assessments ใน phpMyAdmin)
    $sql = "INSERT INTO assessments (evaluator_name, target_user, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, total_score, comment, evidence_file) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssiiiiiiiiiiiss", $evaluator, $target, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $total, $comment, $file_name);

        if ($stmt->execute()) {
            // สำเร็จ! ส่งกลับไปหน้าประวัติของคนนั้น
            echo "<script>
                    alert('บันทึกผลเรียบร้อย! คะแนนรวม: $total'); 
                    window.location='assessment_history.php?target_user=$target';
                  </script>";
        } else {
            echo "Error Save: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error Prepare: " . $conn->error;
    }
}
?>