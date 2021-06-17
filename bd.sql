CREATE DATABASE IF NOT EXISTS alfredo_practica;
USE alfredo_practica;

CREATE TABLE usuarios(
	id_usuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombre_usuario VARCHAR(80),
	genero_usuario ENUM('F','M'),
	email_usuario VARCHAR(80),
	password_usuario VARCHAR(80),
	perfil_usuario ENUM('Alumno','Profesor'),
	fecha_crea_usuario TIMESTAMP,
	status_usuario enum('Activo','Inactivo') DEFAULT 'Activo' NOT NULL
);

INSERT INTO usuarios VALUES(null,'juan','M','juan@gmail.com','123','Profesor',now(),'Activo');
INSERT INTO usuarios VALUES(null,'pedro','M','pedro@gmail.com','123','Profesor',now(),'Inactivo');
INSERT INTO usuarios VALUES(null,'raquel','F','raquel@gmail.com','123','Alumno',now(),'Activo');
INSERT INTO usuarios VALUES(null,'mariana','F','mariana@gmail.com','123','Alumno',now(),'Inactivo');
