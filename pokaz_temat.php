<?php
if(!isset($_GET["id_tematu"])){
    header("Location: tematy.php");
    exit();
}
$mysqli = new mysqli('localhost', 'tomek', '', 'forum');
$mysqli->set_charset("utf8");
$sprawdz_temat_sql = "SELECT nazwa_tematu FROM forum_tematy WHERE id_tematu = '{$_GET["id_tematu"]}'";
$sprawdz_temat_rez = $mysqli->query($sprawdz_temat_sql) or die($mysqli->error);

if($sprawdz_temat_rez->num_rows < 1){
    $wyswietlany_blok = "<p>Wybrałeś nieistniejący temat<br><a href = 'tematy.php'>Sprobuj jeszcze raz</a></p>";
}
else{
    $temat_info = $sprawdz_temat_rez->fetch_array();
    $nazwa_tematu = stripslashes($temat_info['nazwa_tematu']);
    
    $pobierz_posty_sql = "SELECT id_postu, tresc_postu, DATE_FORMAT(data_utworzenia_postu, '%b %e %Y at %r') "
        . "AS fmt_data_utworzenia_postu, autor_postu FROM forum_posty WHERE id_tematu ='".$_GET["id_tematu"]
        ."' ORDER BY data_utworzenia_postu ASC";
    $pobierz_posty_rez = $mysqli->query($pobierz_posty_sql) or die($mysqli->error);
    
    $wyswietlany_blok = <<<LONG
    <p>Posty w temacie: <strong>$nazwa_tematu</strong></p>
    <table width = "100%" cellpadding = "3" cellspacing = "1" border = "1">
        <tr>
            <th>AUTOR</th>
            <th>POST</th>
        </tr>
LONG;
    while($posty_info = $pobierz_posty_rez->fetch_array()){
        $id_postu = $posty_info['id_postu'];
        $tresc_postu = nl2br(stripslashes($posty_info['tresc_postu']));
        $data_utworzenia_postu = $posty_info['fmt_data_utworzenia_postu'];
        $autor_postu = stripslashes($posty_info['autor_postu']);
        
        $wyswietlany_blok .= <<<LONG
        <tr>
            <td width = '35%' valign = 'top'>$autor_postu<br>[$data_utworzenia_postu]</td>
            <td width = '65%' valign = 'top'>$tresc_postu<br><br>
            <a href = 'odpowiedz.php?id_postu=$id_postu'>ODPOWIEDZ</a></td>
        </tr>
LONG;
    }
    $sprawdz_temat_rez->free_result();
    $pobierz_posty_rez->free_result();
    $mysqli->close();
    
    $wyswietlany_blok .= "</table>";
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Tytuł</title>
<meta charset="utf-8">
</head>    
<body>
<h1>TEMATY NA FORUM</h1>
<p>
   <?php echo $wyswietlany_blok; ?> 
</p>
<p><a href = "dodajtemat.html">Czy chcesz dodac nowy temat ?</a></p>
</body>    
</html>