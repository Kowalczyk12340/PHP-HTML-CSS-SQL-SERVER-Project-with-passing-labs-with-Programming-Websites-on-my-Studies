use B18_C2;

CREATE PROCEDURE dbo.Zamowienie_WyswietlDane_OID
@Par_idZamowienie int
AS 
BEGIN
SELECT idZamowienie, StatusZamowienia.Nazwa AS [NazwaStatusuZamowienia], KodKreskowy, DataZamowienia, DataRealizacji, LacznaKwota FROM dbo.Zamowienie
INNER JOIN dbo.StatusZamowienia ON dbo.Zamowienie.idStatusZamowienia = dbo.StatusZamowienia.idStatusZamowienia
WHERE idZamowienie = @Par_idZamowienie;
END;
GO
CREATE PROCEDURE dbo.StatusZamowienia_Wyswietl_Dane
AS
BEGIN
SELECT idStatusZamowienia, Nazwa AS [NazwaStatusuZamowienia] FROM dbo.StatusZamowienia
ORDER BY idStatusZamowienia ASC;
END;
GO 

CREATE PROCEDURE dbo.Klient_Wyswietl_Dane
AS
BEGIN
SELECT idKlient, Imie, Nazwisko FROM dbo.Klient
ORDER BY Nazwisko ASC;
END;
GO

CREATE PROCEDURE dbo.Pracownik_Wyswietl_Dane
AS
BEGIN
SELECT idPracownik, Imie, Nazwisko FROM dbo.Pracownik
ORDER BY Nazwisko ASC;
END;
GO

SELECT idMebel,Nazwa,CenaZaSztuke,KodKreskowy,NazwaRodzaju as [RodzajMebla] FROM dbo.Mebel
                            INNER JOIN dbo.Zamowienie ON dbo.Mebel.idZamowienie = dbo.Zamowienie.idZamowienie
                            INNER JOIN dbo.RodzajMebel ON dbo.Mebel.idRodzajMebel = dbo.RodzajMebel.idRodzajMebel ORDER BY idMebel;
GO

SELECT idMaterial,NazwaMaterial,CenaZaSztuke
                    FROM dbo.Material ORDER BY idMaterial ASC;
GO


SELECT dbo.Zamowienie.idZamowienie AS [Identyfikator Zamowienia], dbo.Klient.Imie + ' ' + dbo.Klient.Nazwisko AS [Dane Klienta],dbo.Pracownik.Imie + ' ' + dbo.Pracownik.Nazwisko AS [Dane Pracownika],dbo.StatusZamowienia.Nazwa AS [NazwaStatusuZamowienia],DataZamowienia,TerminRealizacji,DataRealizacji,LacznaKwota FROM Zamowienie INNER JOIN dbo.Klient ON dbo.Klient.idKlient = dbo.Zamowienie.idKlient INNER JOIN dbo.Pracownik ON dbo.Pracownik.idPracownik = dbo.Zamowienie.idPracownik INNER JOIN dbo.StatusZamowienia ON dbo.StatusZamowienia.idStatusZamowienia = dbo.Zamowienie.idStatusZamowienia ORDER BY idZamowienie;
GO

EXECUTE dbo.Zamowienie_Modyfikuj 3, 2, 3, 2, 'bg44vrr', '2021-06-03', '2021-06-08', '2021-06-09', '321', '2312','NULL';

EXECUTE dbo.Zamowienie_Modyfikuj '6','59', '33','7', '2021-06-03', '2021-06-08', '2021-06-09',0,'2345','';
GO

CREATE PROCEDURE Zamowienie_Modyfikuj2 
@Par_idZamowienie int,
@Par_idKlient int,
@Par_idPracownik int ,
@Par_idStatusZamowienia int,
@Par_DataZamowienia date,
@Par_TerminRealizacji date,
@Par_DataRealizacji date,
@Par_LacznaKwota money
AS
BEGIN
UPDATE dbo.Zamowienie
SET 
idKlient = @Par_idKlient,
idPracownik = @Par_idPracownik,
idStatusZamowienia = @Par_idStatusZamowienia,
DataZamowienia = @Par_DataZamowienia,
TerminRealizacji = @Par_TerminRealizacji,
DataRealizacji = @Par_DataRealizacji,
LacznaKwota = @Par_LacznaKwota
WHERE idZamowienie = @Par_idZamowienie
END;
GO

EXECUTE dbo.Zamowienie_Modyfikuj2 9,8,8,3,'2021-04-23', '2021-04-29', '2021-04-30',3467.0000;

EXECUTE dbo.StatusZamowienia_Wyswietl_Dane;

ALTER PROCEDURE StatusZamowienia_Wyswietl_Dane2
AS 
BEGIN
SELECT idStatusZamowienia, Nazwa AS [NazwaStatusuZamowienia]
FROM dbo.StatusZamowienia
END;
GO

EXECUTE StatusZamowienia_Wyswietl_Dane2;

EXECUTE dbo.Pracownik_Wyswietl_Dane;
