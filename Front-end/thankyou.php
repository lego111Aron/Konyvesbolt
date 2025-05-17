<?php
session_start();
$pdfUrl = isset($_GET["pdf"]) ? $_GET["pdf"] : "";
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Köszönjük a rendelést!</title>
</head>
<body>
    <h1>Köszönjük a vásárlást!</h1>
    <p>A számla hamarosan megnyílik. Ha nem, <a href="<?php echo htmlspecialchars($pdfUrl); ?>" target="_blank">kattints ide a megnyitáshoz</a>.</p>

    <script>
        window.onload = function() {
            const pdfUrl = <?php echo json_encode($pdfUrl); ?>;
            if (pdfUrl) {
                window.open(pdfUrl, "_blank");
            }
            // opcionális: automatikus visszairányítás pár másodperc múlva
            setTimeout(() => {
                window.location.href = "../../Front-end/books.php";
            }, 5000);
        };
    </script>
</body>
</html>
