CREATE PROCEDURE Histogr
@date1 DATE, 
@date2 DATE
AS
SET NOCOUNT ON 
DECLARE @tblHisto TABLE(
	namaPenyakit VARCHAR(50),
	kemunculan int
)
INSERT INTO @tblHisto
SELECT Penyakit.namaDiagnosis , COUNT(Penyakit.idPenyakit)
FROM 
CheckUp JOIN Record ON CheckUp.idCheckUp = Record.idCheckUp
 JOIN Gejala ON gejala.idgejala = record.idgejala
 JOIN Diagnosis ON gejala.idgejala = diagnosis.idgejala
 JOIN Penyakit ON Diagnosis.idPenyakit = penyakit.idPenyakit
WHERE Tanggal BETWEEN @date1 AND dateadd(day,1,@date2)
GROUP BY Penyakit.namaDiagnosis,Penyakit.idPenyakit

SELECT namaPenyakit,kemunculan
FROM @tblHisto

exec Histogr '2019-05-08' , '2019-05-08'