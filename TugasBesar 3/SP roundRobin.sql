ALTER PROCEDURE insRoundRobinGejala
	@idCheckUp INT,
	@idGejala INT
AS
	
	DECLARE 
		@barisMax INT, -- Mendapatkan Baris maksimal dari table config
		@baris INT, -- baris yang harus diisi
		@id INT -- menyimpan id checkup untuk agregasi

	--Table idCheckUO untuk diagregasi
	CREATE TABLE #preparePasien(
		idCheckUp INT
	)

	--Mencari baris yang harus diisi
	SELECT
		@baris = config.baris
	FROM
		Config

	--Mencari Baris maksimal
	SELECT
		@barisMax = totalBaris
	FROM
		Config



	--Memasukkan data ke Table
	UPDATE Record
	SET idCheckUp = @idCheckUp, idGejala = @idGejala
	WHERE Baris = @baris

	--Update baris pada config
	IF(@baris = @barisMax)
	BEGIN
		SET @baris = 1
		--Mencari id2 check up
		INSERT INTO #preparePasien
		SELECT
			Record.idCheckUp
		FROM
			Record

		--Cursor untuk memasukan data ke table agregat
		DECLARE Agregat CURSOR
		FOR
			SELECT
				#preparePasien.idCheckUp
			FROM
				#preparePasien
		OPEN Agregat
		FETCH NEXT FROM Agregat INTO @id
		WHILE(@@FETCH_STATUS = 0)
		BEGIN
			EXEC AgregatPenyakit @id

			FETCH NEXT FROM Agregat INTO @id
		END

		CLOSE Agregat
		
	END
	ELSE
	BEGIN
		SET @baris = @baris + 1
	END

	UPDATE CONFIG
	SET baris = @baris

