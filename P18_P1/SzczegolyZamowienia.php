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
                    $idZamowienie= $_GET["wybrany_id"];
                    if ($idZamowienie == "")
                    die("<p class=' msg error'>Nie wybrano zamówienia uslugi.</p><p><a href='index.php'>Powrót do listy zamówień.</a></p>");
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
                    $komenda_sql = "EXECUTE dbo.Zamowienie_WyswietlDane_OID $idZamowienie";
                    $zbior_wierszy = sqlsrv_query($polaczenie,$komenda_sql);

                    print("<h2>Zamówienia</h2>");
                    print("<table>
                    <thead>
                        <tr>
                            <td><a href='index.php?sort=NazwaStatusuZamowienia'>Nazwa Statusu</a></td>
                            <td><a href='index.php?sort=KodKreskowy'>Kod Kreskowy</a></td>
                            <td><a href='index.php?sort=LacznaKwota'>Kwota Łączna</a></td>
                            <td><a href='index.php?sort=DataZamowienia'>Okres Od</a></td>
                            <td><a href='index.php?sort=DataRealizacji'>Okres Do</a></td>
                        </tr>
                    </thead>
                    <tbody>
                        ");

                        if(sqlsrv_has_rows($zbior_wierszy)== false)
                        {
                        print("<tr
                                   <td clospan='6'>Brak danych zamówień w bazie</td>
                    </tr>
                ");

                }
                else
                {

                while($wiersz = sqlsrv_fetch_array($zbior_wierszy, SQLSRV_FETCH_ASSOC))
                {;
                $NazwaStatusuZamowienia = $wiersz["NazwaStatusuZamowienia"];
                $KodKreskowy = $wiersz["KodKreskowy"];
                $LacznaKwota = $wiersz["LacznaKwota"];
                $DataZamowienia =  $wiersz["DataZamowienia"];
                $DataZamowienia =  $DataZamowienia->Format("Y-m-d");
                $DataRealizacji =  $wiersz["DataRealizacji"];
                $DataRealizacji =  $DataRealizacji->Format("Y-m-d");

                print("
                <tr>
                    <td> $NazwaStatusuZamowienia</td>
                    <td> $KodKreskowy</td>
                    <td> $LacznaKwota</td>
                    <td> $DataZamowienia</td>
                    <td> $DataRealizacji</td>
                </tr>
                ");
                }



                }
                // Zwolnienie zasobów - wyniku zapytania.
                if ($zbior_wierszy != null)
                sqlsrv_free_stmt($zbior_wierszy);

                print("</tbody>
            </table>
        <br />
        ");

        // Zamknięcie połączenia z serwerem.
        if ($polaczenie != false)
        sqlsrv_close($polaczenie);
        }
                    

        print("<p><a href='Zarzadzanie.php' class='powrot'>Powrót do Zarzadzania.</a></p>");
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