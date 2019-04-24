CREATE PROCEDURE Sejarah
	@pasien VARCHAR (128)
AS
	
	DECLARE
		@id INT, --id dari pasien
		@idCheckUp INT

	--Table CheckUp dari pasien
	CREATE TABLE #checkUpHistory (
		idCheckUp INT
	)
	
	--Table Penyakit pasien
	CREATE TABLE #historyPenyaki(
		namaPenyakit VARCHAR (125)
	)

	--Mencari ID pasien
	SELECT
		@id = Pasien.idPasien
	FROM
		Pasien
	WHERE 
		Pasien.namaPasien = @pasien --Pasien.namaPasien LIKE  '%'+@pasien+'%'

	--Mencari Sejarah CheckUp Pasien
	INSERT INTO #checkUpHistory
	SELECT
		Hasil.idCheckUp
	FROM
		Hasil
	WHERE
		Hasil.idPasien = @id

	--Cursor untuk mendapatkan sejarah penyakit pasien
	DECLARE sejarah CURSOR
	FOR
		SELECT
			idCheckUp
		FROM
			#checkUpHistory

	OPEN sejarah
	FETCH NEXT FROM	sejarah INTO @idCheckUp 

	WHILE(@@FETCH_STATUS = 0)
	BEGIN
		
		--Memasukan ke table sejarah penyakit
		INSERT INTO #historyPenyaki
		SELECT DISTINCT
			*
		FROM
			dbo.diagFunct(@idCheckUp)

		FETCH NEXT FROM sejarah INTO @idCheckUp

	END

	CLOSE sejarah
	DEALLOCATE sejarah

	--Menampilkan sejarah penyakit
	SELECT DISTINCT
		#historyPenyaki.namaPenyakit
	FROM
		#historyPenyaki
			




