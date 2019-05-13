ALTER PROCEDURE histo4
AS
SET NOCOUNT ON
DECLARE @tblHisto4 TABLE(
	namaGejala varchar(50),
	jumlahGejala int
)
INSERT INTO @tblHisto4

select namaGejala , count(gejala.idGejala) as 'jumlah gejala'
from record join gejala on record.idGejala =Gejala.idGejala
group by namagejala ,gejala.idGEjala

select *
from @tblHisto4

exec histo4