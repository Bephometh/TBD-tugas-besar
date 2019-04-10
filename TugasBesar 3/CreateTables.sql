CREATE TABLE Pasien(
idPasien int identity(1,1) Primary key,
namaPasien varChar(50) NOT NULL,
);

CREATE TABLE Gejala(
idGejala int identity(1,1) Primary key ,
namaGejala varChar(50) NOT NULL
--idPasien int NOT NULL Foreign Key (idPasien) REFERENCES Pasien (idPasien)
);

CREATE TABLE Penyakit(
idPenyakit int identity(1,1) Primary key,
namaDiagnosis varChar(50),
lamaWaktuSakit dateTime NOT NULL,
jumlahGejala int NOT NULL
);

CREATE TABLE Diagnosis(
idGejala int NOT NULL, Foreign Key (idGejala) REFERENCES Gejala (idGejala),
idPenyakit int NOT NULL, Foreign Key (idPenyakit) REFERENCES Penyakit (idPenyakit)
);

CREATE TABLE CheckUp(
idCheckUp int identity(1,1) Primary key,
Tanggal dateTime NOT NULL
);

CREATE TABLE Record (
idCheckUp int NOT NULL ,Foreign Key (idCheckUp) REFERENCES CheckUp(idCheckUp),
idGejala int NOT NULL , Foreign Key (idGejala) REFERENCES Gejala (idGejala)
);

CREATE TABLE Hasil(
idPasien int NOT NULL ,Foreign Key (idPasien) REFERENCES Pasien(idPasien),
idCheckUp int NOT NULL ,Foreign Key (idCheckUp) REFERENCES CheckUp(idCheckUp)
);


