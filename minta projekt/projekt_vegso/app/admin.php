<?php
    include "scripts/connectDB.php";

    $func = isset($_GET['func']) ? $_GET['func'] : null;

    function colorListItem($listItem){
        $chosenListItem = $GLOBALS['func'];

        if ($chosenListItem != null){
            return $listItem === $chosenListItem ? "style='background-color: #e0e0e0 !important'" : "";
        } else {
            return "";
        }
    }

?>

<div class="container mt-5">
    <h2 class="mb-4">Adatok kezelése</h2>
    <ul class="list-group" id="functionList">
        <ul class="list-group" id="addList">
            <h5 class="list-group-item bg-secondary text-light">Adatok felvétele</h5>
            <li class="list-group-item" <?php echo colorListItem("addBook") ?>><a href="?page=admin&func=addBook">Könyv</a></li>
            <li class="list-group-item" <?php echo colorListItem("addStore") ?>><a href="?page=admin&func=addStore">Áruház</a></li>
            <li class="list-group-item" <?php echo colorListItem("addStock") ?>><a href="?page=admin&func=addStock">Készlet</a></li>
            <li class="list-group-item" <?php echo colorListItem("addPublisher") ?>><a href="?page=admin&func=addPublisher">Kiadó</a></li>
            <li class="list-group-item" <?php echo colorListItem("addGenre") ?>><a href="?page=admin&func=addGenre">Műfaj</a></li>
            <li class="list-group-item" <?php echo colorListItem("addAuthor") ?>><a href="?page=admin&func=addAuthor">Szerző</a></li>
        </ul>
        <ul class="list-group" id="modifyList">
            <h5 class="list-group-item bg-secondary text-light">Adatok módosítása</h5>
            <li class="list-group-item" <?php echo colorListItem("modBook")?>><a href="?page=admin&func=modBook">Könyv</a></li>
            <li class="list-group-item" <?php echo colorListItem("modStore")?>><a href="?page=admin&func=modStore">Áruház</a></li>
            <li class="list-group-item" <?php echo colorListItem("modStock")?>><a href="?page=admin&func=modStock">Készlet</a></li>
            <li class="list-group-item" <?php echo colorListItem("modPublisher")?>><a href="?page=admin&func=modPublisher">Kiadó</a></li>
            <li class="list-group-item" <?php echo colorListItem("modGenre")?>><a href="?page=admin&func=modGenre">Műfaj</a></li>
            <li class="list-group-item" <?php echo colorListItem("modAuthor")?>><a href="?page=admin&func=modAuthor">Szerző</a></li>
        </ul>
    </ul>
</div>

<hr class="mt-5 ml-5 mr-5 bg-light">

<div>
    <?php

    switch ($func) {
        case 'addBook' :
            include_once('admin_funcs/add/addBookForm.php');
            break;
        case 'addStore':
            include_once('admin_funcs/add/addStoreForm.php');
            break;
        case 'addStock':
            include_once('admin_funcs/add/addStockForm.php');
            break;
        case 'addPublisher':
            include_once('admin_funcs/add/addPublisherForm.php');
            break;
        case 'addGenre':
            include_once('admin_funcs/add/addGenreForm.php');
            break;
        case 'addAuthor':
            include_once('admin_funcs/add/addAuthorForm.php');
            break;

        case 'modBook' :
            include_once('admin_funcs/mod/modBookForm.php');
            break;
        case 'modStore' :
            include_once('admin_funcs/mod/modStoreForm.php');
            break;
        case 'modStock' :
            include_once('admin_funcs/mod/modStockForm.php');
            break;
        case 'modPublisher' :
            include_once('admin_funcs/mod/modPublisherForm.php');
            break;
        case 'modGenre' :
            include_once('admin_funcs/mod/modGenreForm.php');
            break;
        case 'modAuthor' :
            include_once('admin_funcs/mod/modAuthorForm.php');
            break;
        default :
            echo '<div class="container mt-5"><p>Nincs funkció kiválasztva</p></div>';
    }
    ?>
</div>