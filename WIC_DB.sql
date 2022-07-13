CREATE DATABASE IF NOT EXISTS WIC_DB;

CREATE TABLE IF NOT EXISTS Users (

    userId int(3) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    userUsername varchar(128) NOT NULL,
    userPassword varchar(128) NOT NULL,
    userMail varchar(128) NOT NULL
    
);


INSERT INTO  Users
VALUES ('1','StavrouI','$2y$10$MzwhZvaoupJClUD0VNJzmubGmjBb90K6REAIC.eXEMxvDm0nOXkpm','stavroujohn@gmail.com'),
        ('2','KonstantinosT','$2y$10$uzReQ0lM52F53emq8IPS.e5BOB0GWvgGli2KxwI/InD73x0R2ZS/u','kontsig@gmail.com'),
        ('3','NanosG','$2y$10$xGuI4VhsBur5nmpJO4VNGOzfpIMx2Gnv3xE.CKe9heNlzUHzKHEhu','nanosgio@gmail.com');