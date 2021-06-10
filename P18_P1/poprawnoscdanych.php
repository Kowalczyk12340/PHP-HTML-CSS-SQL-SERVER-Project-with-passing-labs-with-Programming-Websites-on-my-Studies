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
            <div class="ObszarPotwierdzeniaDanych">
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
                    
                    if(!isset($_GET['IdentyfikatorZamowienia']) ||  ($_GET['IdentyfikatorZamowienia']=="") || (!is_numeric($_GET['IdentyfikatorZamowienia'])) ||
                       !isset($_GET['DaneKlienta']) ||  ($_GET['DaneKlienta']=="") || (!is_numeric($_GET['DaneKlienta'])) || 
                       !isset($_GET['DanePracownika']) ||  ($_GET['DanePracownika']=="") || (!is_numeric($_GET['DanePracownika'])) || 
                       (!isset($_GET['StatusZamowienia']))  ||  ($_GET['StatusZamowienia']=="")   || (!isset($_GET['DataZlozenia']))  ||  ($_GET['DataZlozenia']=="") 
                       || (!isset($_GET['TerminRealizacji']))  ||  ($_GET['TerminRealizacji']=="") 
                       || (!isset($_GET['DataRealizacji']))  ||  ($_GET['DataRealizacji']=="") //(checkdate($_GET['DataRealizacji']))   
                       || !isset($_GET['CenaLaczna']) ||  ($_GET['CenaLaczna']=="") || (!is_numeric($_GET['CenaLaczna'])) ||
                       !isset($_GET['idZamowienieUsluga']) || 
                       ($_GET['idZamowienieUsluga']=="") || 
                       (!is_numeric($_GET['idZamowienieUsluga'])) ||
                       !isset($_GET['idZamowienia']) || 
                       ($_GET['idZamowienia']=="") || 
                       (!is_numeric($_GET['idZamowienia'])) ||
                       !isset($_GET['idUslugi']) || 
                       ($_GET['idUslugi']=="") || 
                       (!is_numeric($_GET['idUslugi'])) ||
                       (!isset($_GET['OkresOd']))  ||  ($_GET['OkresOd']=="") ||
                       (!isset($_GET['OkresDo']))  ||  ($_GET['OkresDo']=="") 
                      )
                    {
                        print("<p class='msg error'>Dane są nie poprawne</p>");
                        print("<p><a href='index.php' class='powrot'>Powrót do formularza</a></p>");
                    }
                    else
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
                            //print("<p class='msg success'>Polaczenie z baza $serwer powiodlo sie.</p>");
                            $idZamowienie = $_GET["IdentyfikatorZamowienia"];
                            $DaneKlienta = $_GET["DaneKlienta"];
                            $DanePracownika = $_GET["DanePracownika"];
                            $StatusZamowienia = $_GET["StatusZamowienia"];
                            $DataZlozenia =  $_GET["DataZlozenia"];
                            $TerminRealizacji=  $_GET["TerminRealizacji"];
                            $DataRealizacji =  $_GET["DataRealizacji"];
                            $CenaLaczna=  $_GET["CenaLaczna"];
                            
                            $idMebelMaterial =  $_GET["idMebelMaterial"];
                            $idMaterial =  $_GET["idMaterial"];
                            $idMebel =  $_GET["idMebel"];
                            $Ilosc=  $_GET["Ilosc"];
                            $Cena=  $_GET["Cena"];
                            $Opis=  $_GET["Opis"];

                            $komenda_sql = "EXECUTE dbo.Zamowienie_Wstaw ' $idZamowienie', '$DaneKlienta', ' $DanePracownika', '$StatusZamowienia', '$DataZamowienia',' $TerminRealizacji', ' $DataRealizacji' ,$LacznaKwota, $Uwagi";
                            $komenda_sql_2 = "EXECUTE dbo.MebelMaterial_Wstaw '$idMebelMaterial','$idMaterial', '$idMebel', '$Ilosc',' $Cena','$Opis' ";

                            $rezultat = sqlsrv_query($polaczenie,$komenda_sql);
                            $rezultat2 = sqlsrv_query($polaczenie,$komenda_sql_2);
                            if ($rezultat == false)
                            {
                                print("<p class='msg error'>Zapisanie danych zamówień &nbsp<strong> $idZamowienie</strong>  w bazie nie powiodło się.</p>");
                                print_r(sqlsrv_errors(), true);
                            }
                            else
                            {
                                print("<p class='msg success'>Dane  zamówień<strong>$idZamowienie</strong>zostały zapisane w bazie.</p>");
                            }
                            if( $rezultat2 == false)
                            {
                                print("<p class='msg error'>Zapisanie danych zamówień  Usługi &nbsp<strong>$idZamowienieUsluga</strong>  w bazie nie powiodło się.</p>");
                                print_r(sqlsrv_errors(), true);
                            }
                            else
                            {
                                print("<p class='msg success'>Dane  zamówień Usługi<strong>$idZamowienieUsluga</strong>zostały zapisane w bazie.</p>");
                            }
                            print("<p> <br /><a href='index.php' class='powrot'>Powrót do strony głównej.</a></p>");
                        }
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