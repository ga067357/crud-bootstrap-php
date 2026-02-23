DROP DATABASE IF EXISTS wda_crud;
CREATE DATABASE wda_crud CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE wda_crud;

CREATE TABLE customers (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) NOT NULL,
  cpf_cnpj varchar(14) NOT NULL,
  birthdate datetime NOT NULL,
  address varchar(255) NOT NULL,
  hood varchar(100) NOT NULL,
  zip_code varchar(8) NOT NULL,
  city varchar(100) NOT NULL,
  state varchar(100) NOT NULL,
  phone varchar(11) NOT NULL,
  mobile varchar(11) NOT NULL,
  ie varchar(14) NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL
);

INSERT INTO customers 
(name, cpf_cnpj, birthdate, address, hood, zip_code, city, state, phone, mobile, ie, created, modified) 
VALUES 
('Fulano de Tal', '123.456.789-00', '1989-01-01', 'Rua da Web, 123', 'Internet', '12345678', 'Teste', 'SP', '1555555555', '15955555555', '12345678932', '2025-08-27 12:10:00', '2025-08-27 12:10:00'),
('Ciclano de Tal', '987.654.321-00', '1990-02-02', 'Rua da Programação, 456', 'Internet', '87654321', 'Exemplo', 'RJ', '2199999999', '21988888888', '98765432100', '2025-08-27 12:15:00', '2025-08-27 12:15:00');

CREATE TABLE airplanes (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  prefix varchar(10) NOT NULL,
  model varchar(30) NOT NULL,
  manufacturer varchar(50) NOT NULL,
  crew int NOT NULL,
  manufacture_date datetime NOT NULL,
  image varchar(100),
  created datetime NOT NULL,
  modified datetime NOT NULL
);

INSERT INTO airplanes 
(prefix, model, manufacturer, crew, manufacture_date, image, created, modified) 
VALUES 
('PT-ABC', '737-800', 'Boeing', 189, '2005-07-15 00:00:00', 'boeing737.jpg', '2025-08-27 12:20:00', '2025-08-27 12:20:00'),
('PR-XYZ', 'A320', 'Airbus', 5, '2010-09-10 00:00:00', 'airbus320.jpg', '2025-08-27 12:25:00', '2025-08-27 12:25:00');

CREATE TABLE usuarios(
    id int AUTO_INCREMENT not null PRIMARY KEY,
    nome varchar(50) not null,
    user varchar(50) not null,
    password varchar(100) not null,
    foto varchar(50),
    nivel varchar(10) not null DEFAULT 'user'
);

-- Senhas criptografadas usando md5:
-- admin123 = 0192023a7bbd73250516f069df18b500
-- user123  = 6ad14ba9986e3615423dfca256d04e3f

INSERT INTO usuarios (nome, user, password, nivel) VALUES
('Admin Master', 'admin', '0192023a7bbd73250516f069df18b500', 'admin'),
('João Usuário', 'joao', '6ad14ba9986e3615423dfca256d04e3f', 'user'),
('Maria Usuária', 'maria', '6ad14ba9986e3615423dfca256d04e3f', 'user');
