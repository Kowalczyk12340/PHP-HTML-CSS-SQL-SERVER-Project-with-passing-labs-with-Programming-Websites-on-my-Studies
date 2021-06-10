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
            <div class="ObszarKoszyka">
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
                    
                    //  print("<p class='msg success'>Polaczenie z baza $serwer powiodlo sie.</p>")
                    
                    
                    if(!isset($_GET["wybrany_idMaterial"]) && !isset($_GET["wybrany_idMebel"]) )
                    {
                        print("<p class=' msg error'>Koszyk  jest pusty</p><p><br/></p>");
                    }
                    else if(isset($_GET["wybrany_idMaterial"]))
                    {   
                        
                        print("<h2>Koszyk</h2>");
                        print("<table>
                  <thead>
                  <tr>
                    <td><a href='Koszyk.php?sort=Identyfikator'>Identyfikator</a></td>
                    <td><a href='Koszyk.php?sort=UslugaNazwa'>Usługa Nazwa</a></td>
                    <td><a href='Koszyk.php?sort=Cena'>Cena</a></td>
                    </tr>
                    </thead>
                    <tbody>
                    ");
                        $idMaterial = $_GET["wybrany_idMaterial"];

                        $komenda_sql = "SELECT idMaterial,NazwaMaterial,CenaZaSztuke
                    FROM dbo.Material WHERE idMaterial =$idMaterial;";

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
                            $wiersz = sqlsrv_fetch_array($zbior_wierszy,SQLSRV_FETCH_ASSOC);
                            {
                                $idMaterial = $wiersz["idMaterial"];
                                $NazwaMaterial = $wiersz["NazwaMaterial"];
                                $CenaZaSztuke = $wiersz["CenaZaSztuke"];
                                print("
                    <tr>
                    <td> $idMaterial</td>
                    <td>$NazwaMaterial</td>
                    <td>$CenaZaSztuke</td>
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
                        print("
<form id='formularz' action='poprawnoscdanych.php' method='GET' onsubmit='wyslij()'>
    <fieldset>
        <legend>Dane  wysyłkowe</legend>
        <p>
            <label for='IdentyfikatorZamowienia'>Identyfikator Zamowienia</label>
            <input id='IdentyfikatorZamowienia' type='number'  autofocus='autofocus' name ='IdentyfikatorZamowienia' required='required'/>
        </p>
        ");
                        print("<p>
        <label for='DaneKlienta'>Dane Klienta</label>
        <select name='DaneKlienta' id='DaneKlienta'>
                ");

                        $komenda_sql_Klient = "EXECUTE dbo.Klient_Wyswietl_Dane;";

                        $zbior_wierszy_Klient = sqlsrv_query($polaczenie,$komenda_sql_Klient);
                        print("<option value='0'>Wybierz Klienta</option>");

                        while ($wiersz = sqlsrv_fetch_array($zbior_wierszy_Klient, SQLSRV_FETCH_ASSOC))
                        {
                            $idKlient = $wiersz["idKlient"];
                            $Imie= $wiersz["Imie"];
                            $Nazwisko= $wiersz["Nazwisko"];

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

                        while ($wiersz = sqlsrv_fetch_array($zbior_wierszy_Pracownik, SQLSRV_FETCH_ASSOC))
                        {
                            $idPracownik = $wiersz["idPracownik"];
                            $Imie= $wiersz["Imie"];
                            $Nazwisko= $wiersz["Nazwisko"];

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
                        while ($wiersz = sqlsrv_fetch_array($zbior_wierszy_StatusZamowienia, SQLSRV_FETCH_ASSOC))
                        {
                            $idStatusZamowienia = $wiersz["idStatusZamowienia"];
                            $NazwaStatusuZamowienia = $wiersz["NazwaStatusuZamowienia"];
                            print("<option value=' $idStatusZamowienia'>$NazwaStatusuZamowienia</option>");
                        }
                        print("</select>  
         </p>");
                        print(" 
              <p>
            <label for='DataZamowienia'>Data Zamówienia</label>
            <input id='DataZamowienia' type='date'  name ='DataZamowienia' required='required' />
            </p>
              <p>
            <label for='TerminRealizacji'>Termin Realizacji</label>
            <input id='TerminRealizacji' type='date'  name ='TerminRealizacji' required='required'/>
            </p>
            <p>
            <label for='DataRealizacji'>Data Realizacji</label>
            <input id='DataRealizacji' type='date'  name ='DataRealizacji' required='required'  />
            </p>
            <p>
            <label for='LacznaKwota'>Cena Łączna</label>
            <input id='LacznaKwota' type='number' name ='LacznaKwota' required='required' min='0.00' max='1000000.00' step='0.01' value='0.00'/>
            </p>
            </fieldset>
");
                        print("
    <fieldset>
        <legend>Dane wysyłkowe Część 2</legend>
        <p>
            <label for='idZamowienieUsluga'>Identyfikator Uslugi</label>
            <input id='idZamowienieUsluga' type='number'  name ='idZamowienieUsluga' required='required'/>
        </p>
        <p>
            <label for='idZamowienia'>Identyfikator Zamowienia</label>
            <input id='idZamowienia' type='number'  name='idZamowienia'  required='required'/>
        </p>
        <p>
            <label for='idUslugi'>Usluga</label>
            <input id='idUslugi' type='number' name ='idUslugi'  required='required' />
        </p>
        <p>
            <label for='CenaSprzedazyUslugi'>Cena Sprzedazy</label>
            <input id='CenaSprzedazyUslugi' type='number'  name ='CenaSprzedazyUslugi' min='0.00' max='1000000.00' step='0.01' value='0.00'  />
        </p>");
                        print(" 
              <p>
            <label for='OkresOd'>OkresOdUslugi</label>
            <input id='OkresOd' type='date'  name ='OkresOd' required='required' />
            </p>
             <p>
            <label for='OkresDo'>OkresDoUslugi</label>
            <input id='OkresDo' type='date'  name ='OkresDo' required='required' />
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
                    else if(isset($_GET["wybrany_idUrzadzenia"]))
                    {
                            
                        
                        print("<h2>Koszyk</h2>");
                        print("<table>
                  <thead>
                  <tr>
                    <td><a href='Meble.php?sort=idMebel'>Identyfikator</a></td>
                    <td><a href='Meble.php?sort=Nazwa'>Nazwa Urządzenia</a></td>
                    <td><a href='Meble.php?sort=CenaZaSztuke'>Cena</a></td>
                    <td><a href='Meble.php?sort=KodKreskowy'>Producent</a></td>
                    <td><a href='Meble.php?sort=NazwaRodzaju'>Rodzaj mebla</a></td>
                    <td><a href='Meble.php?sort=Opis'>Opis</a></td>
                    </tr>
                    </thead>
                    <tbody>
                    ");

                        if (isset($_GET["sort"]))
                            $sortuj = $_GET["sort"];
                        else
                            $sortuj = "idMebel";

                        $idUrzadzenia = $_GET["wybrany_idUrzadzenia"];
                        
                        $komenda_sql = "SELECT idMebel,NazwaUrzadzenia,CenaZaSztuke,KodKreskowy,NazwaRodzaju as [RodzajMebel],Opis FROM dbo.Mebel
                        INNER JOIN dbo.Zamowienie ON dbo.Mebel.idZamowienie = dbo.Zamowienie.idZamowienie
                        INNER JOIN dbo.RodzajMebel ON dbo.Mebel.idRodzajMebel = dbo.RodzajMebel.idRodzajMebel WHERE idMebel = $idMebel ;";

                        //wykonanie polecenia sql na serwerze
                        $zbior_wierszy = sqlsrv_query($polaczenie,$komenda_sql);

                        if(sqlsrv_has_rows($zbior_wierszy)== false)
                        {
                            print("<tr
            <td clospan='6'>Brak danych usług w bazie</td>
                </tr>
            ");
                        }
                        else
                        {
                            //Petla pobierania wierszy
                            $wiersz = sqlsrv_fetch_array($zbior_wierszy,SQLSRV_FETCH_ASSOC);
                            
                                $idMebel = $wiersz["idMebel"];
                                $Nazwa = $wiersz["Nazwa"];
                                $CenaZaSztuke = $wiersz["CenaZaSztuke"];
                                $KodKreskowy = $wiersz["KodKreskowy"];
                                $NazwaRodzaju = $wiersz["RodzajMebel"];
                                $Opis = $wiersz["Opis"];
                                print("
                    <tr>
                    <td>$idMebel</td>
                    <td>$Nazwa</td>
                    <td>$CenaZaSztuke</td>
                    <td>$KodKreskowy</td>
                    <td>$NazwaRodzaju</td>
                    <td>$Opis</td>
                    </tr>
                        ");
                            
                        }
                        print("</tbody>
                </table>
                <br />
             ");
                        
                        
                    
                    } 
                }
                sqlsrv_close($polaczenie); 
                    ?>
            </div>
        </section>
    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2021 Marcin Kowalczyk </p>
    </footer>
</body>
</html>
