<?php
if((!$_POST["autor_tematu"]) || (!$_POST["nazwa_tematu"]) || (!$_POST["tresc_postu"])){
    header("Location: dodajtemat.html");
    exit;
}

$mysqli = new mysqli('localhost','tomek','','forum');
$mysqli->set_charset("utf8");
$dodaj_temat_sql = "INSERT INTO forum_tematy(nazwa_tematu, data_utworzenia_tematu, autor_tematu) VALUES('{$_POST["nazwa_tematu"]}', now(), '{$_POST["autor_tematu"]}')";
$dodaj_temat_rez = $mysqli->query($dodaj_temat_sql) or die($mysqli->error);
$id_tematu = $mysqli->insert_id;

$dodaj_post_sql = "INSERT INTO forum_posty(id_tematu, tresc_postu, data_utworzenia_postu, autor_postu) VALUES({$id_tematu}, '{$_POST["tresc_postu"]}', now(), '{$_POST["autor_tematu"]}')";
$dodaj_post_rez = $mysqli->query($dodaj_post_sql) or die($mysqli->error);

$mysqli->close();

$wyswietlany_blok = "<p>Temat {$_POST["nazwa_tematu"]} został dodany";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Tytuł</title>
    </head>
    <body>
        <?php
            echo $wyswietlany_blok;
        ?>
    </body>
</html>