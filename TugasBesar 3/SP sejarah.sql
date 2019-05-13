ALTER PROCEDURE Sejarah
	@pasien VARCHAR (128)
AS
	SET NOCOUNT ON
	DECLARE
		@id INT, --id dari pasien
		@idCheckUp INT,
		@tanggal DATE,
		@namaPenyakit VARCHAR(100)

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
		@id = Pasien.idPasien
	FROM
		Pasien
	WHERE 
		Pasien.namaPasien = @pasien --Pasien.namaPasien LIKE  '%'+@pasien+'%'

	--Mencari Sejarah CheckUp Pasien
	INSERT INTO #checkUpHistory
	SELECT
		Hasil.idCheckUp, CONVERT(Date, CheckUp.Tanggal) 
	FROM
		Hasil JOIN CheckUp  on Hasil.idCheckUp = CheckUp.idCheckUp
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
		INSERT INTO #historyPenyakit (namaPenyakit)
		SELECT DISTINCT namaPenyakit
		FROM
			dbo.diagFunct(@idCheckUp)
		
		--Cursor untuk memasukkan tanggal
		DECLARE tanggals CURSOR
		FOR
			SELECT namaPenyakit
			FROM #historyPenyakit
		
		OPEN tanggals
		FETCH NEXT FROM tanggals INTO @namaPenyakit
		WHILE(@@FETCH_STATUS = 0)
		BEGIN
			SELECT
				@tanggal = tanggal
			FROM
				#checkUpHistory 
			WHERE
				idCheckUp = @idCheckUp

			UPDATE #historyPenyakit
			SET Tanggal = @tanggal
			WHERE namaPenyakit = @namaPenyakit

			FETCH NEXT FROM tanggals INTO @namaPenyakit
		END

		CLOSE tanggals
		DEALLOCATE tanggals

		FETCH NEXT FROM sejarah INTO @idCheckUp
	END

	CLOSE sejarah
	DEALLOCATE sejarah

	--Menampilkan sejarah penyakit
	SELECT DISTINCT
		#historyPenyakit.Tanggal, #historyPenyakit.namaPenyakit 
	FROM
		#historyPenyakit
	
			




