CREATE DATABASE IF NOT EXISTS WIC_DB;

CREATE TABLE IF NOT EXISTS Users (

    userId int(3) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    userUsername varchar(128) NOT NULL,
    userPassword varchar(128) NOT NULL,
    userMail varchar(128) NOT NULL
    
);

CREATE TABLE IF NOT EXISTS Admins (

    adminId int(3) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    adminUsername varchar(128) NOT NULL,
    adminPasswword varchar(128) NOT NULL,
    adminMail varchar(128) NOT NULL

)