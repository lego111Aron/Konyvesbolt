<?php
include "scripts/connectDB.php";

function konyvReszletek($konyv_id, $conn) {
    $sql = "
        SELECT
            k.cim,
            s.nev AS szerzo,
            k.ar
        FROM KONYV k
        LEFT JOIN (
            SELECT 
                id, 
                nev 
            FROM SZERZO
        ) s ON k.szerzo_id = s.id
        WHERE 
            k.id = :konyv_id
    ";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":konyv_id", $konyv_id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);
    oci_free_statement($stmt);

    return $row;
}

?>

<div class="container mt-5">
    <h2>Kosaram</h2>
    <?php
    if (!empty($_SESSION["cart"])) {
        $torzsvasarlo = isset($_SESSION["torzsvasarlo"]) && $_SESSION["torzsvasarlo"];
        $kedvezmeny_multiplier = $torzsvasarlo ? 0.9 : 1.0;
        $osszeg = 0;
        echo "
        <table class='table-striped'>
            <tbody>";

        foreach ($_SESSION["cart"] as $konyv_id => $mennyiseg) {
            $konyv = konyvReszletek($konyv_id, $conn);
            $osszeg += $konyv["AR"] * $mennyiseg;
            echo "
                <tr>
                    <td style='width: 30%;'>
                        <img src='assets/productImages/literally.jpg' alt='könyv kép' class='img-fluid' style='max-width: 50%; display: block; margin-left: auto; margin-right: auto;'>
                    </td>
                    <td style='width: 40%;'><p><strong>" . 
                        $konyv["CIM"] . "</strong></p><p><em>" .
                        $konyv["SZERZO"] . "</em></p>
                    </td>
                    <td style='width: 30%;'>
                        <p><strong>Ár:</strong> " . $mennyiseg . " db * " . $konyv["AR"] . " Ft</p>
                    </td>
                    <td>
                        <form action='scripts/deleteFromCart.php' method='post'>
                            <input type='hidden' name='id' value=" . $konyv_id . ">
                            <button type='submit' class='btn btn-danger mr-3' style='width: 35px; height: 35px; padding: 0;'>
                                <svg width='20' height='32' xmlns='http://www.w3.org/2000/svg' style='padding-top: 2px;'>
                                    <image id='cart-delete' href='assets/icons/trash-solid.svg' height='30' width='20' />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            ";
        }

        $kedvezmeny_sor = "";
        if($torzsvasarlo){
            $kedvezmeny_sor .= "
                <tr>
                    <td colspan='4' class='text-right'>
                        Törzsvásárlói kedvezmény: <strong>-10%</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan='4' class='text-right'>
                        Kedvezmény értéke: <strong> -" . ($osszeg - $osszeg * $kedvezmeny_multiplier) . " Ft</strong>
                    </td>
                </tr>";
        }

        $vegosszeg = $torzsvasarlo ? "Végösszeg: <s><em>" . $osszeg . " Ft</em></s> <strong>" . $osszeg * $kedvezmeny_multiplier . " Ft</strong>" : "Végösszeg: <strong>" . $osszeg . " Ft</strong>";

        echo $kedvezmeny_sor . "
                <tr>
                    <td colspan='4' class='text-right'>
                        " . $vegosszeg . "
                    </td>
                </tr>
            </tbody>
        </table>";


        if(!isset($_SESSION["user_id"])){
            echo "
                <p class='float-right'>A vásárláshoz <a href='?page=logreg'>jelentkezz be</a>!</p>
            ";
        } else {
            echo "
                <button type='button' class='btn btn-primary float-right' data-toggle='modal' data-target='#receiptModal'>
                    Vásárlás befejezése
                </button>
            ";

            echo "
                <div class='modal fade' id='receiptModal' tabindex='-1' role='dialog' aria-labelledby='receiptModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='receiptModalLabel'>Vásárlás befejezése</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <form action='scripts/addPurchase.php' method='post'>
                                    <div class='form-group'>
                                        <label for='shippingLocation'>Vásárlási cím:</label>
                                        <input type='text' class='form-control' id='shippingLocation' name='shippingLocation' required>
                                    </div>
                                    <button type='submit' class='btn btn-success float-right mt-3'>Vásárlás jóváhagyása</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            ";
        }

    } else {
        echo "<p>A kosarad üres</p>";
    }
    ?>
</div>
