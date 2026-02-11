<?php 
// 1. ตั้งค่าการเชื่อมต่อฐานข้อมูล (localhost) ตรงนี้เลย
$servername = "localhost";
$username = "root";
$password = "12345678"; // รหัสผ่าน AppServ ของคุณ
$dbname = "my_website";

$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คว่าเชื่อมต่อได้ไหม
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // 2. จุดแก้ปัญหา: ถ้าไม่มีชื่อส่งมา ให้ใช้ค่าเริ่มต้นว่า "ไม่ได้ระบุ"
    $name = isset($_POST['fullname']) ? $_POST['fullname'] : "ไม่ได้ระบุชื่อ";
    $dept = isset($_POST['department']) ? $_POST['department'] : "-";
    
    // รับค่า role (ถ้าไม่มีให้เป็น student)
    $role = isset($_POST['role']) ? $_POST['role'] : "student";

    $sql = "INSERT INTO users (username, email, password, fullname, department, role) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssss", $user, $email, $pass, $name, $dept, $role);

        if ($stmt->execute()) {
            echo "
            <script>
                alert('สมัครสมาชิกสำเร็จแล้ว!');
                window.location = 'login.html';
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>