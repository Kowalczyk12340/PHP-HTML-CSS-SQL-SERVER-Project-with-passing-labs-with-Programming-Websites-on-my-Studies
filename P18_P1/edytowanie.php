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
                    $idZamowienie= $_GET["wybrany_id"];
                    if ($idZamowienie == "")
                        die("<p class=' msg error'>Nie wybrano zamówienia.</p><p><a href='index.php'>Powrót do listy zamówień.</a></p>");
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
                        $komenda_sql = "EXECUTE dbo.Zamowienie_Pobierz_ID  $idZamowienie";
                        $zbior_wierszy = sqlsrv_query($polaczenie,$komenda_sql);

                        if(sqlsrv_has_rows($zbior_wierszy)== false)
                        {
                            print("<tr
            <td clospan='6'>Brak danych zamówień w bazie</td>
                </tr>
            ");
                        }
                        else
                        {
                            $wiersz = sqlsrv_fetch_array($zbior_wierszy, SQLSRV_FETCH_ASSOC);
                            $idZamowienie = $wiersz["idZamowienie"];
                            $DaneKlienta_wyb = $wiersz["idKlient"];
                            $DanePracownika_wyb = $wiersz["idPracownik"];
                            $StatusZamowienia_wyb = $wiersz["idStatusZamowienia"];
                            $DataZamowienia = $wiersz["DataZamowienia"];
                            $DataZamowienia =  $DataZamowienia->format("Y-m-d");
                            $TerminRealizacji=  $wiersz["TerminRealizacji"];
                            $TerminRealizacji =  $TerminRealizacji->format("Y-m-d");
                            $DataRealizacji =  $wiersz["DataRealizacji"];
                            $DataRealizacji =  $DataRealizacji->format("Y-m-d");
                            $LacznaKwota =  $wiersz["LacznaKwota"];
                            $Uwagi = $wiersz["Uwagi"];


                            print("
<form id='formularz' action='edytowanie_pot.php' method='GET' onsubmit='wyslij()'>
    <fieldset>
        <legend>Edycja nowego Zamowienia</legend>
        <p>
            <label for='IdentyfikatorZamowienia'>Identyfikator</label>
            <input id='IdentyfikatorZamowienia' type='number'  autofocus='autofocus' name ='IdentyfikatorZamowienia' required='required' value='$idZamowienie' readonly = 'readonly'/>
        </p>
        ");
                            print("<p>
        <label for='DaneKlienta'>Dane Klienta</label>
        <select name='DaneKlienta' id='DaneKlienta'>
                ");

                            $komenda_sql_Klient = "EXECUTE dbo.Klient_Wyswietl_Dane;";

                            $zbior_wierszy_Klient = sqlsrv_query($polaczenie,$komenda_sql_Klient);
                            print("<option value='0'>Wybierz Klienta</option>");

                            while ($wiersz_kl = sqlsrv_fetch_array($zbior_wierszy_Klient, SQLSRV_FETCH_ASSOC))
                            {
                                $idKlient = $wiersz_kl["idKlient"];
                                $Imie= $wiersz_kl["Imie"];
                                $Nazwisko= $wiersz_kl["Nazwisko"];

                                if ($idKlient ==  $DaneKlienta_wyb)
                                    print("<option value='$idKlient' selected='selected'>$Imie $Nazwisko</option>");
                                else
                                    print("<option value='$idKlient'>$Imie $Nazwisko</option>");
                            }
                            print("</select></p>");

                            print("<p>
                  <label for='DanePracownika'>Dane Pracownika</label>
                   <select name='DanePracownika' id='DanePracownika'>
                    ");

                            $komenda_sql_Pracownik = "EXECUTE dbo.Pracownik_Wyswietl_Dane;";

                            $zbior_wierszy_Pracownik = sqlsrv_query($polaczenie,$komenda_sql_Pracownik);
                            print("<option value='0'>Wybierz Pracownika</option>");

                            while ($wiersz_pr = sqlsrv_fetch_array($zbior_wierszy_Pracownik, SQLSRV_FETCH_ASSOC))
                            {
                                $idPracownik = $wiersz_pr["idPracownik"];
                                $Imie= $wiersz_pr["Imie"];
                                $Nazwisko= $wiersz_pr["Nazwisko"];

                                if ($idPracownik==  $DanePracownika_wyb)
                                    print("<option value='$idPracownik' selected='selected'>$Imie $Nazwisko</option>");
                                else
                                    print("<option value='$idPracownik'>$Imie $Nazwisko</option>");
                            }
                            print("</select></p>");

                            print("
                <p>
              <label for='StatusZamowienia'>Status Zamówienia</label>
                <select name='StatusZamowienia' id='StatusZamowienia'>
                 ");

                            $komenda_sql_StatusZamowienia= "EXECUTE dbo.StatusZamowienia_Wyswietl_Dane2;";

                            $zbior_wierszy_StatusZamowienia = sqlsrv_query($polaczenie,$komenda_sql_StatusZamowienia);

                            print("<option value='0'>Wybierz Status Zamówienia</option>");
                            while ($wiersz_st = sqlsrv_fetch_array($zbior_wierszy_StatusZamowienia, SQLSRV_FETCH_ASSOC))
                            {
                                $idStatusZamowienia = $wiersz_st["idStatusZamowienia"];
                                $NazwaStatusuZamowienia = $wiersz_st["NazwaStatusuZamowienia"];

                                if ($idStatusZamowienia == $StatusZamowienia_wyb)
                                    print("<option value='$idStatusZamowienia' selected='selected'>$NazwaStatusuZamowienia</option>");
                                else
                                    print("<option value='$idStatusZamowienia'>$NazwaStatusuZamowienia</option>");
                            }
                            print("</select>  
         </p>");
                            print(" 
              <p>
            <label for='DataZamowienia'>Data Zamówienia</label>
            <input id='DataZamowienia' type='date' name ='DataZamowienia' required='required' value='$DataZamowienia' />
            </p>
              <p>
            <label for='TerminRealizacji'>Termin Realizacji</label>
            <input id='TerminRealizacji' type='date' name ='TerminRealizacji' required='required'  value='$TerminRealizacji'/>
            </p>
            <p>
            <label for='DataRealizacji'>Data Realizacji</label>
            <input id='DataRealizacji' type='date' name ='DataRealizacji' required='required' value='$DataRealizacji' />
            </p>
            <p>
            <label for='LacznaKwota'>Kwota Łączna</label>
            <input id='LacznaKwota' type='number' name ='LacznaKwota' required='required' min='0.00' max='1000000.00' step='0.01'  value='$LacznaKwota'/>
            </p>
            </fieldset>
    <p>
        <input type='submit' name='subWyslij' value='Wyślij' />
        <input type='reset' name='resWyczysc' value='Wyczyść pola' />
         <input type='button' name='sprPola' value='SprawdzPola'  id='sprawdz' onclick='sprawdzPola( ) '/>
    </p>
</form>
");
                        }
                        // Zwolnienie zasobów - wyniku zapytania.
                        if ($zbior_wierszy != null)
                            sqlsrv_free_stmt($zbior_wierszy);

                        // Zwolnienie zasobów - wyniku zapytania.
                        if ($zbior_wierszy_Klient != null)
                            sqlsrv_free_stmt($zbior_wierszy_Klient);

                        // Zwolnienie zasobów - wyniku zapytania.
                        if ($zbior_wierszy_Pracownik != null)
                            sqlsrv_free_stmt($zbior_wierszy_Pracownik);

                        // Zwolnienie zasobów - wyniku zapytania.
                        if ($zbior_wierszy_StatusZamowienia != null)
                            sqlsrv_free_stmt($zbior_wierszy_StatusZamowienia);
                        // Zamknięcie połączenia z serwerem.
                        if ($polaczenie != false)
                            sqlsrv_close($polaczenie);
                    }
        }
                    ?>
                 
                </div>
            </section>
        <footer>
            <p>Wszelkie prawa zastrzeżone &copy; 2021 Marcin Kowalczyk </p>
        </footer>
    </body>
</html>