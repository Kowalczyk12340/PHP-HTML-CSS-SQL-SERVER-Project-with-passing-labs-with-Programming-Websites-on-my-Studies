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
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel='shortcut icon' type='image/x-icon' href='img/logo.png' />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
        <link rel='stylesheet' href='styleProjekt11.css' type='text/css' />
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
                        print("<h2>Zamówienia</h2>");
                        print("<table>
                  <thead>
                  <tr>
                    <td><a href='Zarzadzanie.php?sort=Identyfikator Zamowienia'>Identyfikator </a></td>
                    <td><a href='Zarzadzanie.php?sort=Dane Klienta'>Dane Klienta</a></td>
                    <td><a href='Zarzadzanie.php?sort=Dane Pracownika'>Dane Pracownika</a></td>
                    <td><a href='Zarzadzanie.php?sort=NazwaStatusuZamowienia'>Nazwa Statusu Zamówienia</a></td>
                    <td><a href='Zarzadzanie.php?sort=DataZamowienia'>Data Zamówienia</a></td>
                    <td><a href='Zarzadzanie.php?sort=TerminRealizacji'>Termin Realizacji</a></td>
                    <td><a href='Zarzadzanie.php?sort=DataRealizacji'>Data Realizacji</a></td>
                    <td><a href='Zarzadzanie.php?sort=LacznaKwota'>Kwota Łączna</a></td>
                    <td class='tbl_operacje'></td>
                    <td class='tbl_operacje'></td>
                    <td class='tbl_operacje'></td>
                    </tr>
                    </thead>
                    <tbody>
                    ");

                        if (isset($_GET["sort"]))
                            $sortuj = $_GET["sort"];
                        else
                            $sortuj = "Identyfikator Zamowienia";

                        //wykonanie polecenia sql na serwerze
                        $komenda_sql = "SELECT dbo.Zamowienie.idZamowienie AS [Identyfikator Zamowienia], dbo.Klient.Imie + ' ' + dbo.Klient.Nazwisko AS [Dane Klienta],dbo.Pracownik.Imie + ' ' + dbo.Pracownik.Nazwisko AS [Dane Pracownika],dbo.StatusZamowienia.Nazwa AS [NazwaStatusuZamowienia],DataZamowienia,TerminRealizacji,DataRealizacji,LacznaKwota FROM Zamowienie INNER JOIN dbo.Klient ON dbo.Klient.idKlient = dbo.Zamowienie.idKlient INNER JOIN dbo.Pracownik ON dbo.Pracownik.idPracownik = dbo.Zamowienie.idPracownik INNER JOIN dbo.StatusZamowienia ON dbo.StatusZamowienia.idStatusZamowienia = dbo.Zamowienie.idStatusZamowienia ORDER BY '$sortuj' ";


                        $zbior_wierszy = sqlsrv_query($polaczenie,$komenda_sql);
                        if(sqlsrv_has_rows($zbior_wierszy)== false)
                        {
                            print("<tr
            <td clospan='6'>Brak danych Zamówień w bazie</td>
                </tr>
            ");
                        }
                        else
                        {
                            //Petla pobierania wierszy
                            while($wiersz = sqlsrv_fetch_array($zbior_wierszy,SQLSRV_FETCH_ASSOC))
                            {
                                $idZamowienie = $wiersz["Identyfikator Zamowienia"];
                                $DaneKlienta = $wiersz["Dane Klienta"];
                                $DanePracownika = $wiersz["Dane Pracownika"];
                                $NazwaStatusuZamowienia = $wiersz["NazwaStatusuZamowienia"];
                                $DataZamowienia =  $wiersz["DataZamowienia"];
                                $DataZamowienia =   $DataZamowienia->Format("Y-m-d");
                                $TerminRealizacji=  $wiersz["TerminRealizacji"];
                                $TerminRealizacji =  $TerminRealizacji->Format("Y-m-d");
                                $DataRealizacji =  $wiersz["DataRealizacji"];
                                $DataRealizacji =  $DataRealizacji->Format("Y-m-d");
                                $LacznaKwota=  $wiersz["LacznaKwota"];

                                print("
                    <tr>
                    <td> $idZamowienie</td>
                    <td>$DaneKlienta</td>
                    <td>  $DanePracownika</td>
                    <td> $NazwaStatusuZamowienia</td>
                    <td> $DataZamowienia</td>
                    <td> $TerminRealizacji</td>
                    <td>  $DataRealizacji</td>
                    <td>  $LacznaKwota</td>
                    <td><a href='edytowanie.php?wybrany_id=$idZamowienie' class='edycja'><strong>&#8730;</strong>&nbsp;Edytuj</a></td>
				    <td><a href='usuwanie.php?wybrany_id=$idZamowienie' class='usun'><strong>x</strong>&nbsp;Usuń</a></td>
                    <td><a href='SzczegolyZamowienia.php?wybrany_id=$idZamowienie' class='szczegoly'><strong>x</strong>&nbsp;Szczegóły Zamówienia</a></td>
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
             }
                    ?>
            </div>
        </section>
    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2021 Marcin Kowalczyk </p>
    </footer>
</body>

</html>