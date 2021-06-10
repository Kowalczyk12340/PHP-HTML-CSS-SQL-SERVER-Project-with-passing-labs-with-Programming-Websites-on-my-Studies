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
            <div class="ObszarUslug">
                <h2>Meble</h2>
                <div class="Usluga">
                    <figure>
                        <a href="#"><img src="img/Meble/biurko.png" alt="Przykładowe biurko"></a>
                        <figcaption>Biurka i meble biurowe</figcaption>
                    </figure>
                </div>
                <div class="Usluga">
                <figure>
                    <a href="#"><img src="img/Meble/szafa.png" alt="Meble Salonowe"></a>
                    <figcaption>Szafy i meble salonowe</figcaption>
                </figure>
                </div> 
                <div class="Usluga">
                <figure>
                    <a href="#"><img src="img/Meble/kredens.png" alt="Kredens"></a>
                    <figcaption>Kredens i meble sypialniane</figcaption>
                </figure>
                </div>
        </div>
        </section>
        <section>
    <div class="ObszarUrzadzen">
        <h2>Materiały</h2>
            <div class="Urzadzenia">
            <figure>
                <a href="#"><img src="img/Materialy/material2.jpg" alt="Tworzenie mebli"></a>
                <figcaption>Obrabianie mebla wszelkiego typu wg potrzeb klienta</figcaption>
            </figure>
            </div>
            <div class="Urzadzenia">
            <figure>
                <a href="#"><img src="img/Materialy/material.png" alt="Barwa"></a>
                <figcaption>Wybór barwy mebla</figcaption>
            </figure>
            </div> 
            <div class="Urzadzenia">
            <figure>
                <a href="#"><img src="img/Materialy/stolarnia.png" alt="Tworzywo"></a>
                <figcaption>Wybór tworzywa mebla</figcaption>
            </figure>
            </div>
    </div>
        </section>
    <footer>
        <p>Wszelkie prawa zastrzeżone &copy; 2021 Marcin Kowalczyk </p>
    </footer>
</body>
</html>
