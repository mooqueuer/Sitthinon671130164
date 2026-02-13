<?php 
include('db.php'); // เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล

if (isset($_POST['register'])) {
    // 1. รับค่าจากฟอร์ม
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // กำหนดค่าเริ่มต้นถ้าไม่มีส่งมา
    $name = isset($_POST['fullname']) ? $_POST['fullname'] : "ไม่ได้ระบุ";
    $dept = isset($_POST['department']) ? $_POST['department'] : "-";
    $role = isset($_POST['role']) ? $_POST['role'] : "student";

    // -----------------------------------------------------
    // จุดที่เพิ่มใหม่: เช็คก่อนว่ามี Username หรือ Email นี้หรือยัง?
    // -----------------------------------------------------
    $check_sql = "SELECT username FROM users WHERE username = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $user, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // ถ้าเจอข้อมูลซ้ำ (num_rows มากกว่า 0) ให้แจ้งเตือนและดีดกลับ
        echo "
        <script>
            alert('❌ สมัครไม่ผ่าน: ชื่อผู้ใช้ (Username) หรือ อีเมลนี้ มีคนใช้แล้วครับ!');
            window.history.back();
        </script>";
    } else {
        // 2. ถ้าไม่ซ้ำ ค่อยบันทึกลงฐานข้อมูล
        $sql = "INSERT INTO users (username, email, password, fullname, department, role) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssss", $user, $email, $pass, $name, $dept, $role);

            if ($stmt->execute()) {
                echo "
                <script>
                    alert('✅ สมัครสมาชิกสำเร็จแล้ว!');
                    window.location = 'login.html';
                </script>";
            } else {
                echo "Error executing query: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
    $check_stmt->close();
}
$conn->close();
?>