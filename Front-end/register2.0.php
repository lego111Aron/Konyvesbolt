<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book25</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
    <script src="https://kit.fontawesome.com/0b5692342b.js" crossorigin="anonymous"></script>
</head>
<body id="registerBody">


    <div class="container">

        <div class="form-box">
            <h1>Regisztráció</h1>

            <form method="post" action="../Back-end/authentication/register.php" id="register-form">

                <div class="input-group">
                    <div class="input-field" >
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="NEV" id="NEV" placeholder="Név">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="EMAIL" id="EMAIL" placeholder="E-mail cím">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="FELHASZNALONEV" id="FELHASZNALONEV" placeholder="Felhasználónév">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="JELSZO" id="JELSZO" placeholder="Jelszó">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="JELSZO_UJRA" id="JELSZO_UJRA" placeholder="Jelszó újra">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="TELEFON" id="TELEFON" placeholder="Telefonszám" pattern="^06\d{2}\d{3}\d{4}$">
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="LAKCIM" id="LAKCIM" placeholder="Lakcím">
                    </div>
                </div>
                <div class="button-field">
                    <button type="submit">Regisztráció</button>
                    <button type="button" onclick="window.location.href='login.php'">Bejelentkezés</button>
                </div>
            </form>
        </div>
    </div>


<script>

    document.getElementById("register-form").addEventListener("submit", function(event){
        const nev = document.getElementById("NEV").value.trim();
        const email = document.getElementById("EMAIL").value.trim();
        const felhasznalonev = document.getElementById("FELHASZNALONEV").value.trim();
        const jelszo = document.getElementById("JELSZO").value.trim();
        const jelszo_ujra = document.getElementById("JELSZO_UJRA").value.trim();
        const telefon = document.getElementById("TELEFON").value.trim();
        const lakcim = document.getElementById("LAKCIM").value.trim();


        if(!nev || !email || !felhasznalonev || !jelszo || !jelszo_ujra || !telefon || !lakcim){
            alert("Kérem, töltsön ki minden mezőt!");
            event.preventDefault();
            return;
        }

        if(jelszo !== jelszo_ujra){
            alert("Nem egyezik meg a két jelszó!");
            event.preventDefault();
            return;
        }

    });


</script>

</body>
</html>