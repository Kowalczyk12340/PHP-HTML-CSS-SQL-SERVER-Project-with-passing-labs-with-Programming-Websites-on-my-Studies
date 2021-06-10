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
                <div class="ObszarLogowania">
                        <?php
                    if ((!isset($_POST["txtKonto"])) || ($_POST["txtKonto"] == "") || (!isset($_POST["pwdHaslo"])) || ($_POST["pwdHaslo"] == ""))
                    {
                        $_SESSION["zalogowany"] = false;

                        if (isset($_SESSION["uzytkownik"]))
                            unset($_SESSION["uzytkownik"]);

                        die("<p class='msg error'>Nieprawidłowa nazwa konta lub hasło.</p><p><br/></p>
				<p><a href='index.php' class='powrot'>Powrót do formularza logowania</a></p>");
                    }

                    $KontoForm = trim($_POST["txtKonto"]);
                    //echo ($KontoForm);
                    $HasloForm = trim($_POST["pwdHaslo"]);
                    $hashed_password = password_hash($HasloForm, PASSWORD_DEFAULT);
                    //echo ($hashed_password); 


                    // Dane połączenia z bazą danych.
                    $serwer = 'LAPTOP-JQEIHRHI\SQL';

                    $dane_polaczenia = array('Database' => 'B18_C2', 'CharacterSet' => 'UTF-8');
                   
                   //Próba połączenia z serwerem baz danych.
                   $polaczenie = sqlsrv_connect($serwer, $dane_polaczenia);

                    if ($polaczenie == false)
                    {
                        die("<p class=' msg error'>Połączenie z serwerem $serwer nie powiodło się.</p><p><br/></p>
		<p><a href='index.php' class='powrot'>Powrót do formularza logowania</a></p>");
                        // die(print_r(sqlsrv_errors(), true));
                    }

                    $komenda_sql = "SELECT idUzytkownik, Imie, Nazwisko, Haslo, DataZarejestrowania FROM dbo.Uzytkownik WHERE Konto = '$KontoForm';";

                    $zbior_wierszy = sqlsrv_query($polaczenie, $komenda_sql);

                    if (sqlsrv_has_rows($zbior_wierszy) == false)
                    {
                        $_SESSION["zalogowany"] = false;

                        if (isset($_SESSION["uzytkownik"]))
                            unset($_SESSION["uzytkownik"]);

                        die("<p class='msg error'>Nieprawidłowa nazwa konta lub hasło.</p><p><br/></p>
				<p><a href='index.php' class='powrot'>Powrót do formularza logowania</a></p>");
                    }
                    else
                    {
                        $uzytkownik_dane = sqlsrv_fetch_array($zbior_wierszy, SQLSRV_FETCH_ASSOC);

                        $idUzytkownik = $uzytkownik_dane["idUzytkownik"];
                        // echo ($IdUzytkownik);
                        $Imie = $uzytkownik_dane["Imie"];
                        //echo ($Imie);
                        $Nazwisko = $uzytkownik_dane["Nazwisko"];
                        //echo ($Nazwisko);
                        $Haslo = $uzytkownik_dane["Haslo"];
                        //echo ($Haslo);
                        $DataZarejestrowania = $uzytkownik_dane["DataZarejestrowania"];

                        // Weryfikacja wprowadzonego hasła (zabezpieczona przed atakami typu "timing attack" - http://php.net/manual/en/function.password-verify.php).
                        if (password_verify($HasloForm,$Haslo))
                        {
                            $_SESSION["zalogowany"] = true;
                            $_SESSION["uzytkownik"] = $KontoForm;

                            print("<p class='msg success'>Witaj, <strong>$Imie $Nazwisko</strong>! <br /><br /> Jesteś zalogowany(a) jako <strong>$KontoForm</strong>.</p>");
                            print("<p> <br /><a href='index.php' class='msg success'>Przejdź do Strony głównej</a></p>");
                            print("<p><br /></p><p><br /><a href='logowanie_koniec.php' class='powrot'>Wyloguj</a></p>");
                        }
                        else
                            die("<p class='msg error'>Nieprawidłowa nazwa konta lub hasło.</p><p><br/></p>
				            <p><a href='Logowanie.php' class='powrot'>Powrót do formularza logowania</a></p>");
                    }		
                    ?>
                </div>
            </section>
        <footer>
            <p>Wszelkie prawa zastrzeżone &copy; 2021 Marcin Kowalczyk </p>
        </footer>
    </body>
</html>