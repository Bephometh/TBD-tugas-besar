CREATE TABLE AgregasiPenyakit(
	Tanggal DATE,
	Penakit VARCHAR(258),
	Pasien VARCHAR (258) NOT NULL
)

ALTER TABLE AgregasiPenyakit
ADD idCheckUp INT

EXEC Sejarah 'Aldo'