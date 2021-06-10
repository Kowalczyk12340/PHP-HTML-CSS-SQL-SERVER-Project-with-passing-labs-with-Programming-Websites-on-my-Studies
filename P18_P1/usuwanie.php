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
                    $idZamowienie = $_GET["wybrany_id"];
                    if ($idZamowienie == "")
                        die("<p class=' msg error'>Nie wybrano Zamówienia.</p><p><a href='index.php'>Powrót do listy Zamówień</a></p>");

                    print("<h2>Usuwanie danych Zamówienia</h2>");
                    print("<p class='msg warn'>Czy na pewno usunąć dane Zamówienia o identyfikatorze <strong> $idZamowienie</strong>?</p>");
                    print("<p><br /><a href='usuwanie_pot.php?idZamowienie= $idZamowienie' class='usun'>Tak, usuń dane</a>&nbsp;&nbsp;&nbsp;
	<a href='Zarzadzanie.php' class='powrot'>Anuluj</a></p><p><br /></p>");
                    print("<p><a href='Zarzadzanie.php' class='powrot'>Powrót do listy Zamówień.</a></p>");
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