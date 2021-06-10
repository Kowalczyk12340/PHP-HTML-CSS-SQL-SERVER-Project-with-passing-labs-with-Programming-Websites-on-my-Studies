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
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel='shortcut icon' type='image/x-icon' href='img/logo.png' />
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
        <article>
            <section>
                <div class="ObszarZarzadzania">
                    <?php 
                    if ((isset($_SESSION["zalogowany"]) && ($_SESSION["zalogowany"] == false)) || (!isset($_SESSION["zalogowany"])) || (!isset($_SESSION["uzytkownik"])))
                    {
                        if (isset($_SESSION["zalogowany"]))
                            $_SESSION["zalogowany"] = false;

                        if (isset($_SESSION["uzytkownik"]))
                            unset($_SESSION["uzytkownik"]);

                        session_destroy();

                        die("<p class=' msg error'>Ta funkcja jest dostępna tylko dla zalogowanych użytkowników.</p><p><br/></p>
		<p><a href='index.php' class='powrot'>Przejdź do formularza logowania.</a></p>");
                    }
                    else if (($_SESSION["zalogowany"] == true) && (isset($_SESSION["uzytkownik"])))
                    {
                        $serwer = 'LAPTOP-JQEIHRHI\SQL';

                        $dane_polaczenia = array('Database' => 'B18_C2', 'CharacterSet' => 'UTF-8');
                       
                       //Próba połączenia z serwerem baz danych.
                       $polaczenie = sqlsrv_connect($serwer, $dane_polaczenia);

                    if($polaczenie == false ) 
                    {
                        print("<p class='msg error'>Połączenie z bazą danych $serwer nie powiodło się.</p>");
                        die( print_r( sqlsrv_errors(), true));
                    }
                    else //jesli polaczenie sie powiodlo
                    {
                        $idZamowienie = $_GET["IdentyfikatorZamowienia"];
                        $DaneKlienta = $_GET["DaneKlienta"];
                        $DanePracownika = $_GET["DanePracownika"];
                        $StatusZamowienia = $_GET["StatusZamowienia"];
                        $DataZamowienia =  $_GET["DataZamowienia"];
                        $TerminRealizacji=  $_GET["TerminRealizacji"];
                        $DataRealizacji =  $_GET["DataRealizacji"];
                        $LacznaKwota=  $_GET["LacznaKwota"];
                        
                        $komenda_sql = "EXECUTE dbo.Zamowienie_Modyfikuj2 '$idZamowienie','$DaneKlienta', '$DanePracownika','$StatusZamowienia', '$DataZamowienia',' $TerminRealizacji', '$DataRealizacji',' $LacznaKwota'";
                        
                        $zbior_wierszy = sqlsrv_query($polaczenie,$komenda_sql);
                        $wiersze_zmienione = sqlsrv_rows_affected($zbior_wierszy);
                        if ($zbior_wierszy == false)
                        {
                            print("<p class='msg error'>Modyfikacja danych zamówień <strong> $idZamowienie </strong> w bazie nie powiodła się.</p>");
                            print_r(sqlsrv_errors(), true);
                        }
                        else if ($wiersze_zmienione == 1)
                            print("<p class=' msg success'>Zmodyfikowane dane zamówień <strong> $idZamowienie</strong> zostały zapisane w bazie.</p>");
                        else if ($wiersze_zmienione == 0)
                            print("<p>W bazie nie ma danych zamówień o identyfikatorze <strong> $idZamowienie</strong>.</p>");

                        print("<p> <br /><a href='Zarzadzanie.php' class='powrot'>Powrót do listy zamówień.</a></p>");

                        // Zwolnienie zasobów - wyniku zapytania.
                        if($zbior_wierszy != null)
                        {
                            sqlsrv_free_stmt($zbior_wierszy);
                        }
                        // Zamknięcie połączenia z serwerem.
                        if ($polaczenie != false) 
                            sqlsrv_close($polaczenie);	 
                    }
            }
                    ?>
                </div>
            </section>
        </article>
        <footer>
            <p>Wszelkie prawa zastrzeżone &copy; 2021 Marcin Kowalczyk </p>
        </footer>
    </body>
</html>