<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ISBN = trim($_POST['ISBN'] ?? '');
    $kiadas = trim($_POST['KIADAS'] ?? '');
    $cim = trim($_POST['CIM'] ?? '');
    $oldalszam = floatval($_POST['OLDALAK_SZAMA'] ?? 0);
    $ar = floatval($_POST['AR'] ?? 0);
    $adoszam = trim($_POST['ADOSZAM'] ?? '');
    $szerzok = trim($_POST['szerzok'] ?? '');
    $mufaj = trim($_POST['mufaj'] ?? '');
    $almufajok = $_POST['almufajok'] ?? [];
    $mindenjo=true;

    if (!is_array($almufajok)) {
        $almufajok = [$almufajok]; 
    }
    

    $szerzoktomb= explode(",", $szerzok);
    $szerzoktomb = array_map('trim', $szerzoktomb);

    if (empty($ISBN) || empty($kiadas) || empty($cim) || $oldalszam <= 0 || $ar <= 0 || empty($adoszam) || empty($szerzok) || empty($mufaj)||count($almufajok) == 0) {
        echo '<br><b>Kérem, töltse ki az összes mezőt!<b>';
        $mindenjo=false;
    } else {
        
        
        $sql = "INSERT INTO konyv (ISBN, KIADAS, CIM, OLDALAK_SZAMA, AR, ADOSZAM, ID)
        VALUES (:isbn, TO_DATE(:kiadas, 'YYYY-MM-DD'), :cim, :oldalszam, :ar, :adoszam, :mufaj)";
        
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":isbn", $ISBN);
        oci_bind_by_name($stmt, ":kiadas", $kiadas);
        oci_bind_by_name($stmt, ":cim", $cim);
        oci_bind_by_name($stmt, ":oldalszam", $oldalszam);
        oci_bind_by_name($stmt, ":ar", $ar);
        oci_bind_by_name($stmt, ":adoszam", $adoszam);
        oci_bind_by_name($stmt, ":mufaj", $mufaj);

        if (oci_execute($stmt)) {
            echo "A könyv sikeresen hozzá lett adva!";
        } else {
            $e = oci_error($stmt);
            echo "Hiba történt a könyv hozzáadása során: " . $e['message'];
            $mindenjo=false;
        }

        oci_free_statement($stmt);
        $jelenlegi_szerzok = array();
        if($mindenjo){
            
            $sql="SELECT NEV FROM SZERZO";
            $stmt = oci_parse($conn, $sql);
    
            if (oci_execute($stmt)) { 
                while ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    $jelenlegi_szerzok[] = $row['NEV'];
                }
            } else {
                $e = oci_error($stmt);
                echo "Hiba történt a szerzők lekérdezése során: " . $e['message'];
                $mindenjo=false;
            }
    
            oci_free_statement($stmt);
       
        }
        if($mindenjo){
            //Ha nincs benne a szerző még, hozzáadjuk
            foreach($szerzoktomb as $szerzo) {
                if (!in_array($szerzo, $jelenlegi_szerzok)) {
                    $sql = "INSERT INTO SZERZO (NEV) VALUES (:szerzo)";
                    $stmt = oci_parse($conn, $sql);
                    oci_bind_by_name($stmt, ":szerzo", $szerzo);
                    oci_execute($stmt);
                    oci_free_statement($stmt); 
                }
            }
    
            //Kapcsolótábla feltöltése
            $szerzo_id_parok = array();
            $sql = "SELECT ID, NEV FROM SZERZO";
            $stmt = oci_parse($conn, $sql);
            oci_execute($stmt);
    
            while ($row = oci_fetch_assoc($stmt)) {
                $szerzo_id_parok[$row['NEV']] = $row['ID'];
            }
            oci_free_statement($stmt);
    
            foreach ($szerzoktomb as $szerzo) {
                $szerzo = trim($szerzo);
                $sql = "INSERT INTO SZEREZ (ISBN, ID) VALUES (:isbn, :szerzo_id)";
                $stmt = oci_parse($conn, $sql);
                oci_bind_by_name($stmt, ":isbn", $ISBN);
                oci_bind_by_name($stmt, ":szerzo_id", $szerzo_id_parok[$szerzo]);
                oci_execute($stmt);
                oci_free_statement($stmt); 
            }
        }

        

        if($mindenjo){
            //Akműfajok mentése
            print_r($almufajok);
            foreach ($almufajok as $almufaj) {
                $sql = "INSERT INTO ALMUFAJA (ISBN, ID) VALUES (:ISBN, :almufaj_id)";
                $stmt = oci_parse($conn, $sql);
                oci_bind_by_name($stmt, ":ISBN", $ISBN);
                oci_bind_by_name($stmt, ":almufaj_id", $almufaj);
                oci_execute($stmt);
                oci_free_statement($stmt);
            }
        }

        if($mindenjo){
            //képek mentése
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['kep'])) {
                $fajl = $_FILES['kep'];
            
                if ($fajl['error'] === UPLOAD_ERR_OK) {
                    $kiterjesztes = strtolower(pathinfo($fajl['name'], PATHINFO_EXTENSION));
                    $engedelyezett = ['jpg', 'jpeg', 'png'];
            
                    if (!in_array($kiterjesztes, $engedelyezett)) {
                        die("Nem engedélyezett fájltípus! Csak JPG, JPEG és PNG lehet.");
                    }
            
                    $celMappa = './img/';
                    $fajnev = $ISBN . ".jpg"; 
                    $celUt = $celMappa . $fajnev;
        
                    if ($kiterjesztes === 'png') {
                        $image = imagecreatefrompng($fajl['tmp_name']);
                    } else {
                        $image = imagecreatefromjpeg($fajl['tmp_name']);
                    }
            
                    if ($image === false) {
                        die("Nem sikerült betölteni a képet.");
                    }
                    if (imagejpeg($image, $celUt, 90)) {
                        echo "Fájl sikeresen konvertálva és mentve: $celUt";
                    } else {
                        echo "Hiba a fájl mentésénél!";
                    }
            
                    imagedestroy($image); 
                } else {
                    echo "Hiba a feltöltésnél: " . $fajl['error'];
                }
            }
        }


        




       
    }
    oci_close($conn);
    if($mindenjo){
        header("Location: ../Front-end/");
    }else{
        echo'<br><br><a href="../Front-end/bookregister.php">Vissza a felvitelhez</a>';
    }
}
?>
