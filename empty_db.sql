-- db creation
CREATE TABLE `horaires-salles`.courses (
                                           course_id            int  NOT NULL  AUTO_INCREMENT,
                                           name                 varchar(1000)    ,
                                           CONSTRAINT pk_courses_course_id PRIMARY KEY ( course_id )
) engine=InnoDB;

CREATE TABLE `horaires-salles`.rooms (
                                         room_id              int  NOT NULL  AUTO_INCREMENT,
                                         name                 varchar(100)    ,
                                         description          varchar(1000)    ,
                                         CONSTRAINT pk_rooms_room_id PRIMARY KEY ( room_id )
) engine=InnoDB;

CREATE TABLE `horaires-salles`.timeslots (
                                             timeslot_id          int  NOT NULL  AUTO_INCREMENT,
                                             start_hour           int    ,
                                             start_minute         int    ,
                                             end_hour             int    ,
                                             end_minute           int    ,
                                             CONSTRAINT pk_timeslots_timeslot_id PRIMARY KEY ( timeslot_id )
) engine=InnoDB;

CREATE TABLE `horaires-salles`.weekdays (
                                            weekday_id           int  NOT NULL  AUTO_INCREMENT,
                                            name_fr              varchar(100)    ,
                                            name_en              varchar(100)    ,
                                            name_de              varchar(100)    ,
                                            CONSTRAINT pk_weekdays_weekday_id PRIMARY KEY ( weekday_id )
) engine=InnoDB;

CREATE TABLE `horaires-salles`.registrations (
                                                 registration_id      int  NOT NULL  AUTO_INCREMENT,
                                                 weekday_id           int    ,
                                                 course_id            int    ,
                                                 room_id              int    ,
                                                 CONSTRAINT pk_registrations_registration_id PRIMARY KEY ( registration_id )
) engine=InnoDB;

CREATE INDEX idx_registrations_weekday_id ON `horaires-salles`.registrations ( weekday_id );

CREATE INDEX idx_registrations_course_id ON `horaires-salles`.registrations ( course_id );

CREATE INDEX idx_registrations_room_id ON `horaires-salles`.registrations ( room_id );

CREATE TABLE `horaires-salles`.timeslots_registrations (
                                                           ts_reg_id            int  NOT NULL  AUTO_INCREMENT,
                                                           timeslot_id          int    ,
                                                           registration_id      int    ,
                                                           CONSTRAINT pk_timeslots_registrations_ts_reg_id PRIMARY KEY ( ts_reg_id )
) engine=InnoDB;

CREATE INDEX idx_timeslots_registrations_timeslot_id ON `horaires-salles`.timeslots_registrations ( timeslot_id );
CREATE INDEX idx_timeslots_registrations_registration_id ON `horaires-salles`.timeslots_registrations ( registration_id );

ALTER TABLE `horaires-salles`.registrations ADD CONSTRAINT fk_registrations_weekdays FOREIGN KEY ( weekday_id ) REFERENCES `horaires-salles`.weekdays( weekday_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `horaires-salles`.registrations ADD CONSTRAINT fk_registrations_courses FOREIGN KEY ( course_id ) REFERENCES `horaires-salles`.courses( course_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `horaires-salles`.registrations ADD CONSTRAINT fk_registrations_rooms FOREIGN KEY ( room_id ) REFERENCES `horaires-salles`.rooms( room_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `horaires-salles`.timeslots_registrations ADD CONSTRAINT fk_timeslots_registrations FOREIGN KEY ( timeslot_id ) REFERENCES `horaires-salles`.timeslots( timeslot_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `horaires-salles`.timeslots_registrations ADD CONSTRAINT fk_timeslots_registrations2 FOREIGN KEY ( registration_id ) REFERENCES `horaires-salles`.registrations( registration_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `horaires-salles`.timeslots_classes ADD CONSTRAINT fk_timeslots_classes FOREIGN KEY ( class_id ) REFERENCES `horaires-salles`.classes ( class_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `horaires-salles`.timeslots_teachers ADD CONSTRAINT fk_timeslots_teachers FOREIGN KEY ( teacher_id ) REFERENCES `horaires-salles`.teachers ( teacher_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `horaires-salles`.timeslots_classes ADD CONSTRAINT fk_timeslots_classes_registrations FOREIGN KEY ( registration_id ) REFERENCES `horaires-salles`.registrations( registration_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE `horaires-salles`.timeslots_teachers ADD CONSTRAINT fk_timeslots_teachers_registrations FOREIGN KEY ( registration_id ) REFERENCES `horaires-salles`.registrations( registration_id ) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- rooms
INSERT INTO `rooms`(`name`, `description`) VALUES
("A0006", "Petite salle conférence"),
("A1009", "Petite salle conférence"),
("AR027", "Petite salle Arsenaux"),
("AR029", "Grande salle Arsenaux"),
("AR031", "Grande salle Arsenaux"),
("AR033", "Grande salle Arsenaux"),
("AR035", "Grande salle Arsenaux"),
("AR113", "Grande salle Arsenaux"),
("AR117", "Grande salle Arsenaux"),
("AR123", "Auditoire arsenaux"),
("AR383", "Grande salle Arsenaux"),
("AUDEG", "Auditoire Edouard Gremaud"),
("B0004", "Petite salle de classe"),
("B0008", "Labo de chimie"),
("B0022", "Petite salle de classe"),
("B1016", "Labo de chimie"),
("B2004", "Labo de chimie"),
("B2012", "Labo de chimie"),
("B3003", "Labo de physique"),
("B3004", "Auditoire 60 places"),
("B3008", "Auditoire 30 places"),
("B3016", "Auditoire 80 places"),
("B3020", "Auditoire 60 places"),
("B4008", "Atelier Archi"),
("B4016", "Atelier Archi"),
("B4022", "Atelier A-1"),
("BEA01", "Grande salle Beauregard"),
("BEA02", "Petite salle Beauregard"),
("BEA03", "Grande salle Beauregard"),
("BEA05", "Grande salle Beauregard"),
("BEA06", "Petite salle Beauregard"),
("BEA10", "Petite salle Beauregard"),
("BEA14", "Petite salle Beauregard"),
("BFAH1", "BlueFactory-PICC-AH1"),
("C0004", "Salle PC"),
("C0015", "Petite salle de conférence"),
("C0016", "Labo d'informatique"),
("C0019", "Labo d'informatique"),
("C0022", "Labo d'informatique"),
("C1004", "Petite salle de classe"),
("C1012", "Labo de télécom"),
("C1016", "Labo de télécom"),
("C1022", "Labo de télécom"),
("C2006", "Grande salle de classe"),
("C2012", "Grande salle de classe"),
("C2018", "Grande salle de classe"),
("C2022", "Grande salle de classe"),
("C3006", "Grande salle de classe"),
("C3012", "Grande salle de classe"),
("C3016", "Petite salle de classe"),
("C3020", "Petite salle de classe"),
("C3022", "Petite salle de classe"),
("C4003", "Auditoire 40 places"),
("C4008", "Atelier A-1"),
("C4016", "Atelier A-1"),
("C4022", "Atelier A-1"),
("D0003", "Labo photo-élasticité"),
("D0004", "Petite salle de classe"),
("D0008", "Petite salle de classe"),
("D0013", "Labo de mécanique-chimie"),
("D0016", "Grande salle de classe"),
("D0022", "Labo de mécanique"),
("D1006", "Labo de mécanique"),
("D1014", "Labo de mécanique"),
("D1022", "Grande salle de classe"),
("D2004", "Petite salle de classe"),
("D2008", "Petite salle de classe"),
("D2012", "Petite salle de classe"),
("D2018", "Grande salle de classe"),
("D2022", "Labo d'informatique"),
("D3004", "Petite salle de classe"),
("D3008", "Petite salle de classe"),
("D3012", "Petite salle de classe"),
("D3016", "Petite salle de classe"),
("D3020", "Petite salle de classe"),
("D3022", "Petite salle de classe"),
("D4008", "Atelier A-2"),
("D4016", "Atelier A-2"),
("D4022", "Atelier A-2"),
("EIKON", "Salle EIKON"),
("F0003", "Labo GC (hydraulique)"),
("F0006", "Labo de mécanique"),
("F0016", "Labo de mécanique"),
("F0019", "Labo GC (environnement)"),
("F0027", "Labo GC (géotechnique)"),
("F0101", "Labo GC (structure)"),
("F1006", "Labo de mécanique"),
("FON23", "Labo de chimie"),
("FON28", "Atelier Archi"),
("FON29", "Atelier Archi"),
("G0010", "Labo d'électrotechnique"),
("G0015", "Labo d'électrotechnique"),
("G0107", "Labo d'électrotechnique"),
("G1007", "Labo d'électrotechnique"),
("G1013", "Labo d'électrotechnique"),
("G1017", "Labo d'électrotechnique"),
("G1022", "Labo d'électrotechnique"),
("G1027", "Labo d'électrotechnique"),
("H0031", "Labo de chimie"),
("HEG00", "Innovation Lab"),
("HEG12", "Auditoire HEG"),
("LAUS1", "Salle Lausanne"),
("LAUS2", "Salle Lausanne"),
("SIER1", "Salle Sierre"),
("SION1", "Salle Sion"),
("UNIFR", "Salle UNI-FR"),
("UNINE", "Salle UNI-Neuch"),
("YVERD", "Salle Yverdon"),
("ZH007", "Salle Zürich"),
("ZH013", "Salle Zürich"),
("ZH069", "Salle Zürich");

-- timeslots
INSERT INTO `timeslots`(`start_hour`, `start_minute`, `end_hour`, `end_minute`) VALUES
(8,15,9,00),
(9,5,9,50),
(10,15,11,00),
(11,5,11,50),
(13,0,13,45),
(13,50,14,35),
(15,0,15,45),
(15,50,16,35),
(17,0,17,45),
(17,50,18,35);

-- weekdays
INSERT INTO `weekdays`(`name_fr`,`name_en`,`name_de`) VALUES
("Lundi", "Monday","Montag"),
("Mardi","Tuesday","Dienstag"),
("Mercredi","Wednesday","Mittwoch"),
("Jeudi","Thursday","Donnerstag"),
("Vendredi","Friday","Freitag"),
("Samedi","Saturday","Samstag"),
("Dimanche","Sunday","Sonntag");
