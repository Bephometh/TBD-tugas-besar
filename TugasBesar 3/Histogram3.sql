ALTER PROCEDURE histogr
@date1 DATETIME,
@date2 DATETIME
AS
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

exec histogr '2019-02-05' , '2019-02-11'