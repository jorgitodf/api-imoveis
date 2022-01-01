CREATE SCHEMA `api-imoveis` DEFAULT CHARACTER SET utf8 ;
USE `api-imoveis`;

CREATE USER 'api_imoveis'@'localhost' IDENTIFIED BY '!api_imoveis@2021';
GRANT ALL PRIVILEGES ON `api-imoveis` . * TO 'api_imoveis'@'localhost';
FLUSH PRIVILEGES;
