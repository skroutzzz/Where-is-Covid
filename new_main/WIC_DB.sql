
DROP DATABASE IF EXISTS wic_db;
CREATE DATABASE wic_db;

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
		
			visit_id int NOT NULL PRIMARY KEY,
			visit_userid int, 
			visit_poiid varchar(128),
			visit_timestamp time,
			CONSTRAINT VISIT_USER FOREIGN KEY (visit_userid) REFERENCES myUSERS (user_id)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
			CONSTRAINT VISIT_POI FOREIGN KEY (visit_poiid) REFERENCES myPOIS (poi_id)
			ON DELETE CASCADE
			ON UPDATE CASCADE
);

CREATE TABLE  myCOVID(
			
			covid_id int NOT NULL PRIMARY KEY,
			cov_date date,
			covid_userid int,
			CONSTRAINT COVID_USER FOREIGN KEY (covid_userid) REFERENCES myUSERS (user_id)
			ON DELETE CASCADE
			ON UPDATE CASCADE

);




/*



CREATE TABLE  myCOORD(

			coord_id varchar(128) NOT NULL PRIMARY KEY,
			latitude float,
			longtitude float,
			CONSTRAINT POI_COORD FOREIGN KEY (coord_id) REFERENCES myPOIS (poi_id)
			ON DELETE CASCADE
			ON UPDATE CASCADE
);

*/

--INSERT INTO  myUSERS
--VALUES ('1','StavrouI','$2y$10$MzwhZvaoupJClUD0VNJzmubGmjBb90K6REAIC.eXEMxvDm0nOXkpm','stavroujohn@gmail.com','1'),
--       ('2','KonstantinosT','$2y$10$uzReQ0lM52F53emq8IPS.e5BOB0GWvgGli2KxwI/InD73x0R2ZS/u','kontsig@gmail.com','1'),
--       ('3','NanosG','$2y$10$xGuI4VhsBur5nmpJO4VNGOzfpIMx2Gnv3xE.CKe9heNlzUHzKHEhu','nanosgio@gmail.com','');

	   
