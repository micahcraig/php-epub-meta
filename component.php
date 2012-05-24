<?php
    // modify this to point to your book directory
    #$bookdir = '/home/micah/Dropbox-DandT/Dropbox/BOOKS/PG';
    $bookdir = '/home/micah/view/domandtom/php-epub-meta/books/';


    error_reporting(E_ALL ^ E_NOTICE);

    require('util.php');

    // load epub data
    require('epub.php');
    if(isset($_REQUEST['book'])){
        try{
            $book = $_REQUEST['book'];
            $book = str_replace('..','',$book); // no upper dirs, lowers might be supported later
            $epub = new EPub($bookdir.$book.'.epub');
            if(isset($_REQUEST['componentId'])){
                $component = $_REQUEST['componentId'];
            }
        }catch (Exception $e){
            $error = $e->getMessage();
        }
    }

    header('Content-Type: text/html; charset=utf-8');
    //echo($component);
    echo($epub->component($component));
?>

