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

CREATE TABLE citas(
    id_paciente INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_paciente VARCHAR(80),
    nombre_doctor VARCHAR(80),
    fecha_paciente DATE,
    horario_paciente TIME,
    padecimiento_paciente TEXT,
    notas_paciente TEXT,
    status_paciente enum('Activo','Inactivo') DEFAULT 'Activo' NOT NULL,
    creacion_paciente TIMESTAMP
);

INSERT INTO usuarios VALUES(null,'juan','M','juan@gmail.com','123','Profesor',now(),'Activo');
INSERT INTO usuarios VALUES(null,'pedro','M','pedro@gmail.com','123','Profesor',now(),'Inactivo');
INSERT INTO usuarios VALUES(null,'raquel','F','raquel@gmail.com','123','Alumno',now(),'Activo');
INSERT INTO usuarios VALUES(null,'mariana','F','mariana@gmail.com','123','Alumno',now(),'Inactivo');
