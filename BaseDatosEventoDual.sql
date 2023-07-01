CREATE DATABASE eventoDual_2023;

USE eventoDual_2023;

CREATE TABLE inscripcion(
id_inscripcion INT PRIMARY KEY IDENTITY(1,1),
tipoVisitante VARCHAR(30),
nombres VARCHAR(30),
apellidoPaterno VARCHAR (30),
apellidoMaterno VARCHAR (30),
sexo VARCHAR (10),
correoElectronico VARCHAR (45),
asistencia VARCHAR (10),
fecha DATE,
hora Time
);
-- Consulta Sencilla
select*from inscripcion