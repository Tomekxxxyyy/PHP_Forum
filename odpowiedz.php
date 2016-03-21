<?php
    $mysqli = new mysqli('localhost', 'tomek', '', 'forum');
    $mysqli->set_charset("utf8");
        
    if(!isset($_POST['dodaj_form'])){
        if(!isset($_GET["id_postu"])){
            header("Location: tematy.php");
            exit();
        }
        $weryfikuj_sql = "SELECT ft.id_tematu, ft.nazwa_tematu FROM forum_posty AS fp LEFT JOIN forum_tematy AS ft ON fp.id_tematu = ft.id_tematu WHERE fp.id_postu = '".$_GET['id_postu']."'";
        $weryfikuj_rez = $mysqli->query($weryfikuj_sql) or die($mysqli->error);
        
        if($weryfikuj_rez->num_rows < 1){
            header("Location: tematy.php");
            exit;
        }
        else{
            $temat_info = $weryfikuj_rez->fetch_array();
            $id_tematu = $temat_info['id_tematu'];
            $nazwa_tematu = stripslashes($temat_info['nazwa_tematu']);
            
            $wyswietlany_blok = <<<LONG
            <h1>Odpowiedź na temat $nazwa_tematu</h1>
            <form method = 'post' action = '{$_SERVER['PHP_SELF']}'>
            <p>Twój adres</p>
            <input type = 'text' name = 'autor_postu' size = '40' maxlength = '150'>
            <p>Treść</p>
            <textarea name = 'tresc_postu' rows = '8' cols = '40'></textarea>
            <input type = 'hidden' name = 'id_tematu' value = '$id_tematu'>
            <p>
            <input type = 'submit' name = 'dodaj_form' value = 'Wyslij'>
            </p>
            </form>    
LONG;
        }
        
        $weryfikuj_rez->free_result();
        $mysqli->close();
    }
    else if(isset($_POST['dodaj_form'])){
        if(!isset($_POST['id_tematu']) || !isset($_POST['tresc_postu']) || !isset($_POST['autor_postu'])){
            header("Location: tematy.php");
            exit();
        }
        $add_post_sql = "INSERT INTO forum_posty(id_tematu, tresc_postu, data_utworzenia_postu, autor_postu) VALUES('".$_POST['id_tematu']."','".$_POST['tresc_postu']."',now(),'".$_POST['autor_postu']."')";
        $add_post_rez = $mysqli->query($add_post_sql) or die($mysqli->error);
        
        $mysqli->close();
        header("Location: pokaz_temat.php?id_tematu=".$_POST['id_tematu']);
        exit();
    }
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            echo $wyswietlany_blok;
        ?>
    </body>
</html>