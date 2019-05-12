CREATE PROCEDURE insRoundRobinHasil
	@idCheckUp INT,
	@idPasien INT
AS
	
	DECLARE 
		@baris INT -- baris yang harus diisi

	--Table nama2 pasien untuk diagregasi
	CREATE TABLE #preparePasien(
		namaPasien VARCHAR(200)
	)

	--Mencari baris yang harus diisi
	SELECT
		@baris = config.barisHasil
	FROM
		Config




	--Memasukkan data ke Table
	UPDATE Hasil
	SET idCheckUp = @idCheckUp, idPasien = @idPasien
	WHERE Baris = @baris

	--Update baris pada config
	IF(@baris = 60)
	BEGIN
		SET @baris = 1
	END
	ELSE
	BEGIN
		SET @baris = @baris + 1
	END

	UPDATE CONFIG
	SET barisHasil = @baris

