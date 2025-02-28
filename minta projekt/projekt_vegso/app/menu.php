<?php
    function colorMenuItem($button){
        if (isset($_GET['page'])){
            return $button === $_GET['page'] ? "text-white" : "";
        }else{
            return $button === "products" ? "text-white" : "";
        }
    }


    //menü
    $menuItems = '
        <li class="nav-item">
            <a class="nav-link ' . colorMenuItem("products") . '" href="?page=products">Könyveink</a>
        </li>
        <li class="nav-item">
            <a class="nav-link ' . colorMenuItem("stores") . '" href="?page=stores">Áruházaink</a>
        </li>
        <li>
            <a class="nav-link ' . colorMenuItem("connection") . '" href="?page=connection">Csatlakozás státusz</a>
        </li>
    ';


    $cartButton = '
        <li class="nav-item">
            <a class="nav-link ' . colorMenuItem("cart") . '" href="?page=cart">Kosaram</a>
        </li>
    ';

    $loginButton = '
        <li class="nav-item">
            <a class="nav-link ' . colorMenuItem("logreg") . '" href="?page=logreg">Bejelentkezés</a>
        </li>
    ';

    $logoutButton = '
        <li class="nav-item">
            <a class="nav-link" href="scripts/logout.php">Kijelentkezés</a>
        </li>
    ';

    $myPurchasesButton = '
        <li class="nav-item">
            <a class="nav-link ' . colorMenuItem("myPurchases") . '" href="?page=myPurchases">Vásárlásaim</a>
        </li>
    ';

    $adminButton = '
        <li class="nav-item">
            <a class="nav-link ' . colorMenuItem("admin") . '" href="?page=admin">Admin funkciók</a>
        </li>
    ';

    $searchButton = '
        <li class="nav-item">
            <a class="nav-link img-fluid" href="?page=searchProduct"><img class="search-icon img-fluid" src="assets/icons/magnifying-glass-solid.png" alt="Keresés"></a>
        </li>
    ';


    $topRightButtons = '';

    if (!isset($_SESSION['user_id']) ) {
        // nem bejelentkezett user jobb menüje
        $topRightButtons .= $cartButton . $loginButton;
    } elseif ($_SESSION['admin']) {
        // admin jobb menüje
        $topRightButtons .= $adminButton . $logoutButton;
    } else {
        $topRightButtons .= $cartButton . $myPurchasesButton . $logoutButton;
    }

    // plusz keresés gomb
    $topRightButtons .= $searchButton;
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <!-- Logó -->
    <a class="navbar-brand" href="index.php">
        <img id="logo" src="assets/icons/logo.png" height="50" width="50" alt="logo">
    </a>

    <!-- Toggle gomb kicsi kepernyoknek mert bootstrap is power -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php echo $menuItems; ?>
        </ul>

        <!-- Login/Register gomb -->
        <ul class="navbar-nav ml-auto">
            <?php echo $topRightButtons; ?>
        </ul>
    </div>
</nav>