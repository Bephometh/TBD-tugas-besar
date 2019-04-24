CREATE FUNCTION diagFunct(
	@idCheckUp INT
)
RETURNS @result TABLE(
	namaPenyakit VARCHAR (258)
)
BEGIN
	
	DECLARE
	@idPenyakit INT, --memeriksa penyakit yang dialami
	@minGejala INT, --minimal gejala penyakit
	@gejalaDialami INT --gejala yang dialami

	


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
			(--Me-fetch penayakit dari tabel
				SELECT
					Diagnosis.idPenyakit, Diagnosis.idGejala
				FROM
					Diagnosis
				WHERE
					Diagnosis.idPenyakit = @idPenyakit) as #penyakit 
			INNER JOIN (--Mencari Jumlah Gejala yang dialami Pasien
							SELECT 
								Record.idGejala as id
							FROM
								Record
							WHERE
								Record.idCheckUp = @idCheckUp) as #gejala
			ON #gejala.id = #penyakit.idGejala

		--memeriksa apakah gejala dialami seusai dengan minimal gejala
		IF(@gejalaDialami >= @minGejala)
		BEGIN
			INSERT INTO @result
			SELECT
				Penyakit.namaDiagnosis
			FROM
				Penyakit
			WHERE
				Penyakit.idPenyakit = @idPenyakit
		END

			--Mengupdate Fetch next
		FETCH NEXT FROM
			cariPenyakits
		INTO
			@idPenyakit
	END

	RETURN

END