<?php
session_start();

include "connectDB.php";

$name = $_POST['register-fullname'];
$email = $_POST['register-email'];
$password = $_POST['register-password'];
$password_confirm = $_POST['register-confirm-password'];


if ($password !== $password_confirm) {
    header("Location: ../index.php?page=logreg&regerror=1");
    exit();
}


$sql_check_email = 'SELECT COUNT(*) FROM FELHASZNALO WHERE email = :email';
$stmt_check_email = oci_parse($conn, $sql_check_email);
oci_bind_by_name($stmt_check_email, ':email', $email);
oci_execute($stmt_check_email);
$row = oci_fetch_array($stmt_check_email);
$email_count = $row[0];
oci_free_statement($stmt_check_email);

if ($email_count > 0) {
    header("Location: ../index.php?page=logreg&regerror=2");
    exit();
}


$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$sql_max_id = 'SELECT MAX(ID) FROM FELHASZNALO';
$stmt_max_id = oci_parse($conn, $sql_max_id);
oci_execute($stmt_max_id);
$row = oci_fetch_array($stmt_max_id);
$max_id = $row[0];
oci_free_statement($stmt_max_id);


$new_id = $max_id + 1;


try {
    $sql_insert_user = '
        BEGIN
            INSERT INTO FELHASZNALO (ID, NEV, EMAIL, JELSZO, TORZSVASARLO, ADMIN)
            VALUES (:id, :name, :email, :password, 0, 0);
        END;
    ';

    $stmt_insert_user = oci_parse($conn, $sql_insert_user);

    oci_bind_by_name($stmt_insert_user, ':id', $new_id, 5);
    oci_bind_by_name($stmt_insert_user, ':name', $name, 40);
    oci_bind_by_name($stmt_insert_user, ':email', $email, 40);
    oci_bind_by_name($stmt_insert_user, ':password', $hashed_password, 256);
    

    oci_execute($stmt_insert_user);
    
    oci_commit($conn);
    oci_free_statement($stmt_insert_user);
    oci_close($conn);
    
    header("Location: ../index.php?page=logreg&regerror=0");
    exit();
} catch (Exception $e) {
    oci_rollback($conn);
    oci_free_statement($stmt_insert_user);
    oci_close($conn);
    
    header("Location: ../index.php?page=logreg&regerror=3");
    exit();
}
?>
