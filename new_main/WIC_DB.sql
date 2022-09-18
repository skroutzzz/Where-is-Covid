
DROP DATABASE IF EXISTS wic_db;
CREATE DATABASE wic_db CHARACTER SET utf8  COLLATE utf8_general_ci;
USE  wic_db;

CREATE TABLE  myUSERS (

			user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
			user_username varchar(128) NOT NULL,
			user_password varchar(128) NOT NULL,
			user_email varchar(128) NOT NULL,
			admin_id BIT default 0
    
);

CREATE TABLE  myPOIS(	

			poi_id varchar(128) NOT NULL PRIMARY KEY,
			poi_name varchar(128),
			poi_address text,
			rating int,
			rating_n int,
			populartimes text,
			latitude float,
			longtitude float	

);

CREATE TABLE myPOIS_TYPE(

			type_id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
			poi_type_id varchar(128),
			poi_type_name text,
			CONSTRAINT POI_TYPE FOREIGN KEY (poi_type_id) REFERENCES myPOIS (poi_id)
			ON DELETE CASCADE
			ON UPDATE CASCADE

);

CREATE TABLE  myVISIT(
		
			visit_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
			visit_userid int, 
			visit_poiid varchar(128),
			visit_timestamp datetime,
			visit_estimation int,
			CONSTRAINT VISIT_USER FOREIGN KEY (visit_userid) REFERENCES myUSERS (user_id)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
			CONSTRAINT VISIT_POI FOREIGN KEY (visit_poiid) REFERENCES myPOIS (poi_id)
			ON DELETE CASCADE
			ON UPDATE CASCADE
);

CREATE TABLE  myCOVID(
			
			covid_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
			cov_date date,
			covid_userid int,
			CONSTRAINT COVID_USER FOREIGN KEY (covid_userid) REFERENCES myUSERS (user_id)
			ON DELETE CASCADE
			ON UPDATE CASCADE

);

CREATE TABLE pages
(
  id INTEGER  NOT NULL IDENTITY(1,1)  PRIMARY KEY,
  total_views INTEGER  NOT NULL,
  
);
CREATE TABLE page_views
(
  visitor_ip VARCHAR(255) NOT NULL,
  page_id INTEGER   NOT NULL,
  
CONSTRAINT page_view FOREIGN KEY (page_id) REFERENCES pages (id)
);


/*
INSERT INTO  myUSERS
VALUES ('1','StavrouI','$2y$10$MzwhZvaoupJClUD0VNJzmubGmjBb90K6REAIC.eXEMxvDm0nOXkpm','stavroujohn@gmail.com','1'),
      ('2','KonstantinosT','$2y$10$uzReQ0lM52F53emq8IPS.e5BOB0GWvgGli2KxwI/InD73x0R2ZS/u','kontsig@gmail.com','1'),
      ('3','NanosG','$2y$10$xGuI4VhsBur5nmpJO4VNGOzfpIMx2Gnv3xE.CKe9heNlzUHzKHEhu','nanosgio@gmail.com',''); */

	   
