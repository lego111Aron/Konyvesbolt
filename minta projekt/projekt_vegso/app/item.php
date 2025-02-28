<?php
include "scripts/getItem.php";
include "scripts/getItemStock.php";

$konyv_elerheto = false;
$aruhaz_arr = array();

while (($aruhaz_rekord = oci_fetch_array($cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
    array_push($aruhaz_arr, $aruhaz_rekord);
}

if (count($aruhaz_arr) > 0){ $konyv_elerheto = true; }

$kosarban = isset($_SESSION["cart_added"]) && $_SESSION["cart_added"];
unset($_SESSION["cart_added"]);

$admin = isset($_SESSION["user_id"]) && $_SESSION["admin"];
?>

<div class="container mt-5">
    <?php if ($kosarban): ?>
        <div class="alert alert-success" role="alert">
            Termék hozzáadva a kosaradhoz!
        </div>
    <?php endif; ?>

    <p>
        <a href="?page=products&filter=genre_<?php echo $mufaj_nev ?>">
            <?php echo ucfirst($mufaj_nev); ?>
        </a>
         >
        <a href="?page=products&filter=subgenre_<?php echo $almufaj_nev ?>">
            <?php echo ucfirst($almufaj_nev); ?>
        </a>
    </p>
    <div class="row">
        <div class="col-md-4">
            <img src="assets/productImages/literally.jpg" class="img-fluid" alt="Product Image">
        </div>
        <div class="col-md-8">
            <h6><?php echo $szerzo; ?></h6>
            <h2><?php echo $cim; ?></h2>
            <?php
                if ($konyv_elerheto){
                    echo "<h6 class='text-success'>Raktáron</h6>";
                    if ($kifuto){
                        echo "<h6 class='text-warning'>Kifutó termék!</h6>";
                    }
                }else{
                    echo "<h6 class='text-danger'>Nincs raktáron</h6>";
                }
            ?>
            <h3 class="mt-3"><?php echo $ar; ?> Ft</h3>
            <?php
            if($konyv_elerheto){
                echo '
                    <form action="scripts/addToCart.php" method="post">
                        <input type="hidden" name="item_id" value="' . $item_id . '">
                        <button type="submit" class="btn btn-primary">Kosárba</button>
                    </form>
                ';
            }else{
                echo '
                    <button class="btn btn-secondary">Kosárba</button>
                ';
            }
            ?>
            <div class="row mt-5">
                <div class="col-md-2">
                    <p><strong>Kiadó:</strong></p>
                    <p><strong>Oldalszám:</strong></p>
                    <p><strong>Nyelv:</strong></p>
                    <p><strong>Kategória:</strong></p>
                    <p><strong>Műfaj:</strong></p>
                </div>
                <div class="col-md-4">
                    <p><?php echo $kiado_nev; ?></p>
                    <p><?php echo $oldalszam; ?></p>
                    <p><?php echo $nyelv; ?></p>
                    <p><?php echo $mufaj_nev; ?></p>
                    <p><?php echo $almufaj_nev; ?></p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3>Szinopszis</h3>
                    <p><?php echo $leiras; ?></p>
                </div>
                <div class="col-md-12">
                    <h3>Termékelérhetőség</h3>
                    <?php
                        if ($konyv_elerheto){
                            echo '<p>A termék elérhető következő partnereinknél: </p>';
                            foreach ($aruhaz_arr as $aruhaz) {
                                echo "<li class='ml-5'>";
                                if ($admin){
                                    echo "(" . $aruhaz['MENNYISEG'] . " példány) ";
                                }

                                echo $aruhaz['ARUHAZ_CIM'] . "</li>";
                            }
                        }else{
                            echo '<p>A termék jelenleg nem elérhető.</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>