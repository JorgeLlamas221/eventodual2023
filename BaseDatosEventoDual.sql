CREATE DATABASE eventoDual_2023;

USE eventoDual_2023;

CREATE TABLE inscripcion(
id_inscripcion INT PRIMARY KEY AUTO_INCREMENT,
tipoVisitante VARCHAR(30) NOT NULL,
nombres VARCHAR(30) NOT NULL,
apellidoPaterno VARCHAR (30) NOT NULL,
apellidoMaterno VARCHAR (30) NOT NULL,
sexo VARCHAR (10) NOT NULL,
correoElectronico VARCHAR (45) NOT NULL,
asistencia VARCHAR (10),
fecha DATE,
hora Time
);
