<?php
$mysqli = new mysqli('localhost','tomek','','forum');
$mysqli->set_charset("utf8");
$pobierz_tematy_sql = "SELECT id_tematu, nazwa_tematu, DATE_FORMAT(data_utworzenia_tematu, '%b %e %Y at %r') as fmt_data_utworzenia_tematu, autor_tematu FROM forum_tematy ORDER BY data_utworzenia_tematu DESC";
$pobierz_tematy_rez = $mysqli->query($pobierz_tematy_sql) or die($mysqli->error);

if($pobierz_tematy_rez->num_rows < 1){
    $wyswietlany_blok = "<p><em>Nie ma żadnych tematów</em></p>";
}
else{
    $wyswietlany_blok = <<<LONG
    <table cellpadding = "3" cellspacing = "1" border = "1">
        <tr>
            <th>Temat</th>
            <th>Liczba postów</th>
        </tr>
LONG;
    while($temat_info = $pobierz_tematy_rez->fetch_array()){
        $id_tematu = $temat_info["id_tematu"];
        $nazwa_tematu = stripslashes($temat_info["nazwa_tematu"]);
        $data_utworzenia_tematu = $temat_info["fmt_data_utworzenia_tematu"];
        $autor_tematu = stripslashes($temat_info["autor_tematu"]);
        
        $pobierz_liczbe_postow_sql = "SELECT COUNT(id_postu) AS liczba_postow FROM forum_posty WHERE id_tematu = '".$id_tematu."'";
        $pobierz_liczbe_postow_rez = $mysqli->query($pobierz_liczbe_postow_sql) or die($mysqli->error);
        $posty_info = $pobierz_liczbe_postow_rez->fetch_array();
        $liczba_postow = $posty_info["liczba_postow"];
        
        $wyswietlany_blok .= <<<LONG
        <tr>
            <td><a href='pokaz_temat.php?id_tematu=$id_tematu'><strong>$nazwa_tematu</strong></a><br>
            Utworzono: $data_utworzenia_tematu przez $autor_tematu</td><td align='center'>$liczba_postow</td>
        </tr>        
                
LONG;
    }
    $pobierz_tematy_rez->free_result();
    $pobierz_liczbe_postow_rez->free_result();
    $mysqli->close();
    
    $wyswietlany_blok .= "</table>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tytuł</title>
    <meta charset = "utf-8">
</head>    
<body>
    <h1>Tematy na forum</h1>
    <?php echo $wyswietlany_blok; ?>
    <p><a href = "dodajtemat.html">Czy chcesz dodac nowy temat ?</a></p>
</body>    
</html>