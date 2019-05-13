ALTER PROCEDURE AgregatPenyakit
	--@pasien VARCHAR (128)
	@idCheckUp INT
AS
	SET NOCOUNT ON
	DECLARE
		@id INT, --id dari pasien
		@pasien VARCHAR(200),
		@tanggal DATE,
		@temp INT

	--Table CheckUp dari pasien
	CREATE TABLE #checkUpHistory (
		idCheckUp INT,
		tanggal DATE
	)
	
	--Table Penyakit pasien
	CREATE TABLE #historyPenyakit(
		Tanggal DATE,
		namaPenyakit VARCHAR (125)
	)

	--Table untuk menyimpan Penyakit
	CREATE TABLE #penyakit(
		namaPenyakit VARCHAR(125)
	)

	--Mencari ID pasien
	SELECT
		@id = Hasil.idPasien
	FROM
		Hasil
	WHERE 
		Hasil.idCheckUp = @idCheckUp 

	--Mencari nama Pasien
	SELECT
		@pasien = Pasien.namaPasien
	FROM
		Pasien
	WHERE
		Pasien.idPasien = @id

	--Mencari Sejarah CheckUp Pasien
	INSERT INTO #checkUpHistory
	SELECT
		CheckUp.idCheckUp, CONVERT(Date, CheckUp.Tanggal, 105) 
	FROM
		CheckUp
	WHERE
		CheckUp.idCheckUp = @idCheckUp

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
		INSERT INTO AgregasiPenyakit(Penakit, Pasien, idCheckUp)
		SELECT DISTINCT namaPenyakit, @pasien, @idCheckUp
		FROM
			dbo.diagFunct(@idCheckUp)
		
		--Cursor untuk memasukkan tanggal
		DECLARE tanggal CURSOR
		FOR
			SELECT
				idCheckUp
			FROM 
				AgregasiPenyakit
			WHERE
				idCheckUp = @idCheckUp
		
		OPEN tanggal
		FETCH NEXT FROM tanggal INTO @temp

		WHILE(@@FETCH_STATUS = 0)
		BEGIN
			--Mencari Tanggal ChekUp pasien
			SELECT
				@tanggal = tanggal
			FROM
				#checkUpHistory 
			WHERE
				idCheckUp = @idCheckUp

			--Memasukkan Tanggal berdasarakan idCheckUp
			UPDATE AgregasiPenyakit
			SET Tanggal = @tanggal
			WHERE idCheckUp = @temp

			FETCH NEXT FROM tanggal INTO @temp
		END

		CLOSE tanggal

		FETCH NEXT FROM sejarah INTO @idCheckUp
	END

	CLOSE sejarah
	DEALLOCATE sejarah
