<?php
session_start();
$pdfUrl = isset($_GET["pdf"]) ? $_GET["pdf"] : "";
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Köszönjük a rendelést!</title>
    <link rel="stylesheet" href="StyleSheets/style.css">
</head>
<body id="thankyouBody">

    <!-- Fejléc és menü -->
    <?php include "header.php"; ?>

    <div class="thankyou-container">
        <h1>Köszönjük a vásárlást!</h1>
        <p class="thankyou-message">
            A számla hamarosan megnyílik.<br>
            Ha nem, <a href="<?php echo htmlspecialchars($pdfUrl); ?>" target="_blank" class="thankyou-link">kattints ide a megnyitáshoz</a>.
        </p>
        <p class="thankyou-redirect">Néhány másodperc múlva visszairányítunk a könyvek oldalára.</p>
    </div>

    <script>
        window.onload = function() {
            const pdfUrl = <?php echo json_encode($pdfUrl); ?>;
            if (pdfUrl) {
                window.open(pdfUrl, "_blank");
            }
            setTimeout(() => {
                window.location.href = "../../Front-end/books.php";
            }, 5000);
        };
    </script>
</body>
</html>