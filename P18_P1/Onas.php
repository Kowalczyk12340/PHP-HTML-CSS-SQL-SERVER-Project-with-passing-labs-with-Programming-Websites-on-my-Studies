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
                <div class="ObszarOpisu">
                    <div class="Usluga1">
                        <figure>
                            <a href="#"><img src="img/Meble/soofa.png" alt="Przykładowa sofa"></a>
                            <figcaption>Przykładowa Sofa z nowej kolekcji</figcaption>
                        </figure>
                    </div>
                    <p class="opis">
                        <br/>Nasza firma została założona w lutym 2012 roku. Pomysł narodził się w małym
                        garażu. Z czasem widać było spore zainteresowanie naszą działalnością
                        i ciągły wzrost nowych klientów. Postanowiliśmy się więc 
                        rozbudować i w ten sposób poszerzyć zakres naszych usług.
                        Nasz firma zajmuje się dystrybucją mebli na wymiar, oraz materiałów do nich przeznaczonych.
                        Wszystko co robimy jest z myślą o naszych odbiorcach.
                        Staramy się by każdy z nich był zadowolony. Wszystkie nasze maszyny
                        wykonujemy bardzo dokładnie z dużą dbałością o szczegóły. Jakość
                        i trwałość naszych usług podwyższa fakt, że wszystkie elementy mebli,
                        jak i całościowe projekty sa wykonywane z najwyższej jakości drewna. 
                        Nasza firma wykonuje również specjalne zamówienia 
                        naszych klientów lub oferujemy meble i materiały do mebli przez nas już wykonanych,
                        które znajdziecie państwo na naszej stronie internetowej.
                    </p>
                </div>
            </section>
        <footer>
            <p>Wszelkie prawa zastrzeżone &copy; 2021 Marcin Kowalczyk </p> 
        </footer>
    </body>
</html>