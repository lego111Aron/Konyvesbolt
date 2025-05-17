<?php
// filepath: c:\xampp\htdocs\Konyvesbolt\Back-End\invoice\generate_invoice.php

require_once(__DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php');
include_once("../connect.php");

function getBookDetails($conn, $orderId) {
    $details = [];
    $query = "
        SELECT VK.ISBN, K.CIM, K.AR, VK.DARAB
        FROM VASAROL VK
        JOIN KONYV K ON VK.ISBN = K.ISBN
        WHERE VK.ID = :order_id
    ";

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":order_id", $orderId);
    oci_execute($stmt);

    while ($row = oci_fetch_assoc($stmt)) {
        $details[] = [
            'isbn' => $row['ISBN'],
            'cim' => $row['CIM'],
            'ar' => $row['AR'],
            'darab' => $row['DARAB']
        ];
    }

    oci_free_statement($stmt);
    return $details;
}

function generateInvoicePDF($orderId, $username, $address, $cart, $conn) {
    $bookDetails = getBookDetails($conn, $orderId);

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('dejavusans', '', 10);

    $html = "<h1>Számla</h1>";
    $html .= "<p><strong>Megrendelő:</strong> $username<br>";
    $html .= "<strong>Cím:</strong> $address<br>";
    $html .= "<strong>Rendelés azonosító:</strong> #$orderId<br></p>";

    $html .= "<table border='1' cellpadding='5'>
        <tr><th>Cím</th><th>Mennyiség</th><th>Egységár</th><th>Összesen</th></tr>";

    $total = 0;
    foreach ($bookDetails as $book) {
        $cim = htmlspecialchars($book['cim']);
        $darab = (int)$book['darab'];
        $ar = (float)$book['ar'];
        $osszeg = $ar * $darab;
        $total += $osszeg;

        $html .= "<tr><td>$cim</td><td>$darab</td><td>" . number_format($ar, 0, '', ' ') . " Ft</td><td>" . number_format($osszeg, 0, '', ' ') . " Ft</td></tr>";
    }

    $html .= "</table>";
    $html .= "<h3>Végösszeg: " . number_format($total, 0, '', ' ') . " Ft</h3>";

    $pdf->writeHTML($html, true, false, true, false, '');

    $saveDir = __DIR__ . "/pdf";
    if (!is_dir($saveDir)) {
        mkdir($saveDir, 0777, true);
    }
    $filePath = "$saveDir/szamla_$orderId.pdf";

    $pdf->Output($filePath, 'F');

    return "szamla_$orderId.pdf";
}
?>
