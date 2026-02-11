<?php 
include('db.php'); // เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล

if (isset($_POST['register'])) {
    // 1. รับค่าจากฟอร์ม
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $name = $_POST['fullname'];  // รับค่าชื่อ-นามสกุล
    $dept = $_POST['department']; // รับค่าแผนก
    $role = $_POST['role'];       // รับค่าบทบาท

    // 2. เตรียมคำสั่ง SQL (ต้องใส่ให้ครบทุกช่อง)
    $sql = "INSERT INTO users (username, email, password, fullname, department, role) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // 3. ผูกตัวแปรกับ SQL (s = string 6 ตัว)
        $stmt->bind_param("ssssss", $user, $email, $pass, $name, $dept, $role);

        // 4. สั่งทำงาน
        if ($stmt->execute()) {
            echo "
            <script>
                alert('สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ');
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
$conn->close();
?>