<?php

// csatlakozás az adatbázishoz

$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
        (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
        (SID = orania2)
    )
)";


$conn = oci_connect('C##D48N9S', 'orakulum2002', $tns, 'UTF8');

?>