<?php
session_name("StronaID");
session_start();
?>
<!DOCTYPE html>
<html lang='pl'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Dostawca Mebli na Wymiar</title>
        <meta name='keywords' content='serwisy, internetowe, programowanie' />
        <meta name='description' content='Strona utworzona w ramach PSIN.' />
        <meta name='author' content='Marcin Kowalczyk' />
        <link rel='stylesheet' href='styleProjekt11.css' type='text/css' />
        <link rel='shortcut icon' type='image/x-icon' href='img/logo.png' />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    </head>

    <body>
    <header>
    <h1 class="logo">Meble na Wymiar - Storm Furniture</h1>
        </header>
        <nav id="glowneMenu">
            <ul class="menu">
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="Onas.php">O Nas</a></li>
                <li><a href="Materialy.php">Materiały</a></li>
                <li><a href="Meble.php">Meble</a></li>
                <li><a href="Koszyk.php">Koszyk</a></li>
                <li><a href="Zarzadzanie.php">Zarządzanie Zamówieniami</a></li>
                <li><a href="Logowanie.php">Logowanie </a></li>
            </ul>
        </nav>
            <section>
                <div class="ObszarUslug">
                            <?php   

                         $serwer = 'LAPTOP-JQEIHRHI\SQL';

                         $dane_polaczenia = array('Database' => 'B18_C2', 'CharacterSet' => 'UTF-8');
                       
                       //Próba połączenia z serwerem baz danych.
                       $polaczenie = sqlsrv_connect($serwer, $dane_polaczenia);

                        if($polaczenie == false ) 
                        {
                            print("<p class='msg error'>Polaczenie z baza danych $serwer nie powiodlo sie.</p>");
                            die( print_r( sqlsrv_errors(), true));
                        }else //jesli polaczenie sie powiodlo
                        {
                            //  print("<p class='msg success'>Polaczenie z baza $serwer powiodlo sie.</p>");
                            print("<h2>Materiały</h2>");
                            print("<table>
                  <thead>
                  <tr>
                    <td><a href='Materialy.php?sort=idMaterial'>Identyfikator</a></td>
                    <td><a href='Materialy.php?sort=NazwaMaterial'>Nazwa Materiału</a></td>
                    <td><a href='Materialy.php?sort=CenaZaSztuke'>Cena</a></td>
                    <td class='tbl_operacje'></td>
                    </tr>
                    </thead>
                    <tbody>
                    ");
                            
                            if (isset($_GET["sort"]))
                                $sortuj = $_GET["sort"];
                            else
                                $sortuj = "idMaterial";

                            $komenda_sql = "SELECT idMaterial,NazwaMaterial,CenaZaSztuke
                    FROM dbo.Material ORDER BY $sortuj ASC ;";

                            //wykonanie polecenia sql na serwerze
                            $zbior_wierszy = sqlsrv_query($polaczenie,$komenda_sql);

                            if(sqlsrv_has_rows($zbior_wierszy)== false)
                            {
                                print("<tr
            <td clospan='6'>Brak danych materiałów w bazie</td>
                </tr>
            ");
                            }
                            else
                            {
                                //Petla pobierania wierszy
                                while($wiersz = sqlsrv_fetch_array($zbior_wierszy,SQLSRV_FETCH_ASSOC))
                                {
                                    $idMaterial = $wiersz["idMaterial"];
                                    $NazwaMaterial = $wiersz["NazwaMaterial"];
                                    $CenaZaSztuke = $wiersz["CenaZaSztuke"];
                                    print("
                    <tr>
                    <td> $idMaterial</td>
                    <td>$NazwaMaterial</td>
                    <td>$CenaZaSztuke</td>
                    <td><a href='Koszyk.php?wybrany_idMaterial=$idMaterial' class='zakup'><strong>&#8730;</strong>&nbsp;Kup</a></td>
                    </tr>
                        ");
                                }
                                if($zbior_wierszy != null)
                                {
                                    sqlsrv_free_stmt($zbior_wierszy);
                                }  
                            }
                            print("</tbody>
                </table>
                <br />
             ");
                            sqlsrv_close($polaczenie); 
                        }
                    
                    ?>
                </div>
            </section>
        <footer>
            <p>Wszelkie prawa zastrzeżone &copy; 2021 Marcin Kowalczyk </p>
        </footer>
    </body>
</html>