CREATE PROCEDURE Diag
	@idCheckUp INT
AS
	
	DECLARE
	@idPenyakit INT, --memeriksa penyakit yang dialami
	@minGejala INT, --minimal gejala penyakit
	@gejalaDialami INT --gejala yang dialami

	--Tabel penyakit yang mungkin dialami pasien
	CREATE TABLE #penyakit (
		id INT,
		idGejala INT
	)

	--Tabel penyakit yang dialami pasien
	CREATE TABLE #diagnosis(
		namaPenyakit VARCHAR (258),
	)

	--Table gejala pasie
	CREATE TABLE #gejala(
		id INT
	)

	--Mencari Jumlah Gejala yang dialami Pasien
	INSERT INTO #gejala
	SELECT
		Record.idGejala
	FROM
		Record
	WHERE
		Record.idCheckUp = @idCheckUp

	--Cursor
	DECLARE cariPenyakits cursor
	FOR
	SELECT
		Diagnosis.idPenyakit
	FROM
		Diagnosis

	OPEN cariPenyakits

	FETCH NEXT FROM
		cariPenyakits
	INTO
		@idPenyakit

	--Menghitung jumlah gejala pasien per penyakit
	WHILE(@@FETCH_STATUS = 0)
	BEGIN
		--Me-fetch penayakit dari tabel
		INSERT INTO #Penyakit
		SELECT
			Diagnosis.idPenyakit, Diagnosis.idGejala
		FROM
			Diagnosis
		WHERE
			Diagnosis.idPenyakit = @idPenyakit

		--Mencari minimal gejala
		SELECT
			@minGejala = Penyakit.jumlahGejala
		FROM
			Penyakit
		WHERE
			Penyakit.idPenyakit = @idPenyakit
		
		--Menghitung gejala yang dialami pasien
		SELECT
			@gejalaDialami = COUNT(#gejala.id)
		FROM
			#Penyakit INNER JOIN #gejala on #gejala.id = #penyakit.idGejala

		--memeriksa apakah gejala dialami seusai dengan minimal gejala
		IF(@gejalaDialami >= @minGejala)
		BEGIN
			INSERT INTO #diagnosis
			SELECT
				Penyakit.namaDiagnosis
			FROM
				Penyakit
			WHERE
				Penyakit.idPenyakit = @idPenyakit
		END

		--Mengkosongkan table #penyakit
		DELETE #penyakit

		--Mengupdate Fetch next
		FETCH NEXT FROM
			cariPenyakits
		INTO
			@idPenyakit

	END


	CLOSE cariPenyakits
	DEALLOCATE cariPenyakits



	SELECT DISTINCT
		#diagnosis.namaPenyakit
	FROM
		#diagnosis


