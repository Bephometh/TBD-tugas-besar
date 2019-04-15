CREATE PROCEDURE PenyakitYangMuncul
	@waktuAwal date,
	@waktuAkhir date
AS
	--Cari penyakit sesuai tanggal
	DECLARE @tabelSementara table(
		namaPenyakit1 varChar(50),
		tanggal date
	)

	INSERT INTO @tabelSementara
	SELECT penyakit.namaDiagnosis,CheckUp.tanggal
	FROM Record JOIN Diagnosis ON Diagnosis.idGejala = Record.idGejala
				JOIN Penyakit ON Penyakit.idPenyakit = Diagnosis.idPenyakit
				JOIN CheckUp ON CheckUp.idCheckUp = Record.idCheckUp
	WHERE tanggal >= @waktuAwal AND tanggal <= dateADD(day,1,@waktuAkhir)
	ORDER BY CheckUp.tanggal ASC

	--Hasil penyakit sesuai waktu
	DECLARE @tabelHasil table(
		namaPenyakit varChar(50),
		jumlah int
	)

	INSERT INTO @tabelHasil
	SELECT namaPenyakit1,COUNT(namaPenyakit1)
	FROM @tabelSementara
	GROUP BY namaPenyakit1
	

	SELECT namaPenyakit
	FROM @tabelHasil

	exec PenyakitYangMuncul '2019-02-05','2019-02-11'

	DROP PROCEDURE PenyakitYangMuncul

	
	