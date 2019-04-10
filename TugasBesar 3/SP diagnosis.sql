ALTER PROCEDURE Diag
	@idCheckUp INT
AS
	
	DECLARE
	@gejala INT --Gejala yang dialami pasien

	--Tabel penyakit yang mungkin dialami pasien
	CREATE TABLE #penyakit (
		namaPenyakit VARCHAR (258),
		minimalGejala INT
	)

	--Tabel penyakit yang dialami pasien
	CREATE TABLE #diagnosis(
		namaPenyakit VARCHAR (258),
	)

	--Mencari Jumlah Gejala yang dialami Pasien
	SELECT
		@gejala = COUNT(Record.idGejala)
	FROM
		Record
	WHERE
		Record.idCheckUp = @idCheckUp



	--Mencari hasil checkUp berdasrkan Id checkUp
	INSERT INTO  #penyakit
	SELECT Distinct
		namaDiagnosis, Penyakit.jumlahGejala
	FROM 
		Record 
		join Diagnosis on Record.idGejala = Diagnosis.idGejala 
		join Penyakit on Diagnosis.idPenyakit = Penyakit.idPenyakit
	WHERE
		Record.idCheckUp = @idCheckUp

	--Cursor untuk memeriksa minimal gejala
	INSERT INTO #diagnosis
	SELECT
		#penyakit.namaPenyakit
	FROM
		#penyakit
	WHERE
		@gejala >= #penyakit.minimalGejala

	SELECT
		#diagnosis.namaPenyakit
	FROM
		#diagnosis


