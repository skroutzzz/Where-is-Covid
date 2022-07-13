CREATE DATABASE IF NOT EXISTS WIC_DB;

CREATE TABLE IF NOT EXISTS Users (

    userId int(3) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    userUsername varchar(128) NOT NULL,
    userPassword varchar(128) NOT NULL,
    userMail varchar(128) NOT NULL
    
);


INSERT INTO  Users
VALUES ('101','Stavrou Ioannis','K!mi123','stavroujohn@gmail.com'),
        ('201','Konstantinos Tsigkounis','Skr0utzzz%','kontsig@gmail.com'),
        ('301','Nanos Giorgod','Dvergard12#','nanosgio@gmail.com');