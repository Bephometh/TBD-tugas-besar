ALTER PROCEDURE Histogr
@date1 DATE, 
@date2 DATE
AS
SET NOCOUNT ON 

DECLARE @check int

DECLARE @cariIdCheckUp TABLE(
	idCheckUp int
)

INSERT INTO @cariIdCheckUp
SELECT idCheckUp
FROM CheckUp 
WHERE Tanggal BETWEEN @date1 AND dateadd(day,1,@date2)
--WHERE Tanggal BETWEEN '2019-05-13' AND dateadd(day,1,'2019-05-13')

--tabel akhir
DECLARE @tblHasil TABLE(
	namaPenyakit VARCHAR (125)
)

--cursor
DECLARE search CURSOR
FOR
	SELECT idCheckUp
	FROM @cariIdCheckUp

OPEN search
FETCH NEXT FROM search INTO @check

WHILE(@@FETCH_STATUS = 0)
BEGIN
	INSERT INTO @tblHasil
	SELECT DISTINCT namaPenyakit
	FROM dbo.diagFunct(@check)

	FETCH NEXT FROM search INTO @check
END
CLOSE search
DEALLOCATE search


DECLARE @tblFinal TABLE(
	namaPenyakit varChar(125),
	jumlahPenyakit int
)

INSERT INTO @tblFinal
SELECT namaPenyakit,count(namaPenyakit)
FROM @tblHasil
GROUP BY namaPenyakit

SELECT namaPenyakit,jumlahPenyakit
FROM @tblFinal

 --ambil hasil checkup berdasarkan tanggal
 --tble di loop panggil fungsi diag

 exec Histogr '2019-05-13','2019-05-13'