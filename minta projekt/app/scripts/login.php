<?php
session_start();

include "connectDB.php";

$email_in = $_POST['login-email'];
$password_in = $_POST['login-password'];

$sql = '
    DECLARE
        v_user FELHASZNALO%ROWTYPE;
    BEGIN
        SELECT *
        INTO v_user
        FROM FELHASZNALO
        WHERE email = :email_in;

        :user_id := v_user.ID;
        :nev := v_user.NEV;
        :email := v_user.EMAIL;
        :jelszo := v_user.JELSZO;
        :torzsvasarlo := v_user.TORZSVASARLO;
        :admin := v_user.ADMIN;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            :user_id := NULL;
    END;
';

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ':email_in', $email_in);

oci_bind_by_name($stmt, ':user_id', $user_id, 5);
oci_bind_by_name($stmt, ':nev', $nev, 40);
oci_bind_by_name($stmt, ':email', $email_in_db, 40);
oci_bind_by_name($stmt, ':jelszo', $password_in_db, 100);
oci_bind_by_name($stmt, ':torzsvasarlo', $torzsvasarlo, 1);
oci_bind_by_name($stmt, ':admin', $admin, 1);

oci_execute($stmt);


if ($user_id !== null) {
    if (password_verify($password_in, $password_in_db)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['nev'] = $nev;
        $_SESSION['email'] = $email_in_db;
        $_SESSION['torzsvasarlo'] = (int)$torzsvasarlo == 1 ? true : false;
        $_SESSION['admin'] = (int)$admin == 1 ? true : false;

        oci_free_statement($stmt);
        oci_close($conn);
        header("Location: ../index.php?page=logreg&logsuccess=1");
        exit();
    } else {
        oci_free_statement($stmt);
        oci_close($conn);
        header("Location: ../index.php?page=logreg&loginerror=1");
        exit();
    }
} else {
    oci_free_statement($stmt);
    oci_close($conn);
    header("Location: ../index.php?page=logreg&loginerror=1");
    exit();
}

?>
