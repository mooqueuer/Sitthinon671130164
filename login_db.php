<?php 
session_start();
include('db.php');

if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // แยกหน้าตาม Role
            if ($row['role'] == 'admin') {
                header("location: admin_dashboard.php");
            } else {
                header("location: member.php"); // หน้าสำหรับ User ทั่วไป (เดี๋ยวสร้างเพิ่ม)
            }
        } else {
            echo "<script>alert('รหัสผ่านผิด'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('ไม่พบผู้ใช้'); window.location='login.html';</script>";
    }
}
?>