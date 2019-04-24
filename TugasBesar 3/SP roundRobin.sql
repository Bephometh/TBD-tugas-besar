ALTER PROCEDURE insRoundRobinGejala
	@idCheckUp INT,
	@idGejala INT
AS
	
	DECLARE 
		@baris INT -- baris yang harus diisi

	--Mencari baris yang harus diisi
	SELECT
		@baris = config.baris
	FROM
		Config



	--Memasukkan data ke Table
	UPDATE Record
	SET idCheckUp = @idCheckUp, idGejala = @idGejala
	WHERE Nomor = @baris

	--Update baris pada config
	IF(@baris = 20)
	BEGIN
		SET @baris = 1
	END
	ELSE
	BEGIN
		SET @baris = @baris + 1
	END

	UPDATE CONFIG
	SET baris = @baris

