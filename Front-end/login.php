<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
    <script src="https://kit.fontawesome.com/0b5692342b.js" crossorigin="anonymous"></script>
</head>
<body id="loginBody">

    <div class="container">
        <div class="form-box">
            <h1>Bejelentkezés</h1>
            <form method="post" id="login-form" action="../Back-end/authentication/login.php">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="EMAIL" id="EMAIL" placeholder="E-mail cím">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="JELSZO" id="JELSZO" placeholder="Jelszó">
                    </div>
                </div>
                <div class="button-field">
                    <button type="submit">Bejelentkezés</button>
                    <button type="button" onclick="window.location.href='register2.0.php'">Regisztráció</button>
                </div>
            </form>
        </div>
    </div>


<script>
    document.getElementById("login-form").addEventListener("submit", function(event){
        const email = document.getElementById("EMAIL").value.trim();
        const jelszo = document.getElementById("JELSZO").value.trim();

        if(!email || !jelszo){
            alert("Kérem, töltson ki minden mezőt!");
            event.preventDefault();
        }

    });
</script>

</body>
</html>