<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Bejelentkezés</h2>
                    <form action="scripts/login.php" method="post">
                    <div class="form-group">
                            <input type="email" class="form-control" id="login-email" name="login-email" placeholder="Email-cím" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="login-password" name="login-password" placeholder="Jelszó" required>
                        </div>
                        <?php
                            if(isset($_GET['loginerror'])){
                                echo '<h6 class="text-danger">Helytelen felhasználónév vagy jelszó</h6>';
                            } else if(isset($_GET['logsuccess']) && $_GET['logsuccess'] === '1'){
                                echo
                                    '<h6 class="text-success">Sikeres bejelentkezés... 
                                        <a href="index.php">Tovább >></a>
                                     </h6>';
                            }
                        ?>
                        <button type="submit" class="btn btn-primary">Bejelentkezés</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Regisztráció</h2>
                    <form action="scripts/registration.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="register-fullname" name="register-fullname" placeholder="Teljes név" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="register-email" name="register-email" placeholder="Email-cím" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="register-password" name="register-password" placeholder="Jelszó" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="register-confirm-password" name="register-confirm-password" placeholder="Jelszó ismét" required>
                        </div>
                        <?php
                            if(isset($_GET['regerror'])){
                                switch ($_GET['regerror']){
                                    case '1':
                                        echo '<h6 class="text-danger">A két jelszó nem egyezik</h6>';
                                        break;
                                    case '2':
                                        echo '<h6 class="text-danger">Ezzel az email-címmel már létezik felhasználó</h6>';
                                        break;
                                    case '3':
                                        echo '<h6 class="text-danger">Regisztráció sikertelen</h6>';
                                        break;
                                    default:
                                        echo '<h6 class="text-success">Regisztráció sikeres</h6>';
                                }
                            }
                        ?>
                        <button type="submit" class="btn btn-success">Regisztráció</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>