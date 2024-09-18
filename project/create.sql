CREATE SCHEMA IF NOT EXISTS 4347_ProjectDB_Final;
USE 4347_ProjectDB_Final;
CREATE TABLE IF NOT EXISTS Villain (
 VillainID INT AUTO_INCREMENT PRIMARY KEY,
 Name varchar(255),
 Age INT,
 DOB DATE,
 People_Killed INT,
 Archnemesis INT,
 UNIQUE (VillainID, Archnemesis)
);
-- Alter Villain table to add foreign key constraint
ALTER TABLE Villain
ADD CONSTRAINT fk_villain_archnemesis
FOREIGN KEY (Archnemesis) REFERENCES Hero(HeroID)
ON DELETE SET NULL
ON UPDATE CASCADE;
CREATE TABLE IF NOT EXISTS Hero (
 HeroID INT AUTO_INCREMENT PRIMARY KEY,
 Name varchar(255),
 Age INT,
 DOB DATE,
 People_Saved INT,
 Archnemesis INT,
 AgentID INT default 0,
 Seniority ENUM('Trainee', 'Junior Hero', 'Senior Hero', 'Lead Hero', 'Special Hero'),
 CONSTRAINT fk_hero_villain FOREIGN KEY (Archnemesis) REFERENCES Villain(VillainID) ON 
DELETE SET NULL ON UPDATE CASCADE,
 CONSTRAINT fk_hero_agent FOREIGN KEY (AgentID) REFERENCES Agent(AgentID) ON DELETE 
SET NULL ON UPDATE CASCADE,
 UNIQUE (HeroID, Archnemesis)
);
CREATE TABLE IF NOT EXISTS Agent (
 AgentID INT AUTO_INCREMENT PRIMARY KEY,
 Age INT,
 Salary DECIMAL(10, 2),
 Experience INT,
 Name varchar(255)
);
CREATE TABLE IF NOT EXISTS Leader (
 LeaderID INT AUTO_INCREMENT PRIMARY KEY,
 Name varchar(255),
 DOB DATE,
 Age INT,
 Salary DECIMAL(10, 2),
 Experience INT,
 Role varchar(255)
);
CREATE TABLE IF NOT EXISTS Mission (
 MissionID INT AUTO_INCREMENT PRIMARY KEY,
 Name VARCHAR(255),
 HeroID INT,
 People_Saved INT,
 People_Lost INT,
 VillainID INT,
 Priority_Level ENUM('1', '2', '3', '4', '5'),
 CONSTRAINT fk_mission_hero FOREIGN KEY (HeroID) REFERENCES Hero(HeroID) ON DELETE 
CASCADE ON UPDATE CASCADE,
 CONSTRAINT fk_mission_villain FOREIGN KEY (VillainID) REFERENCES Villain(VillainID) ON 
DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS Superpower (
 SuperpowerID INT AUTO_INCREMENT PRIMARY KEY,
 Description varchar(255),
 Name VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS Hero_Superpowers (
 HeroID INT,
 SuperpowerID INT,
 PRIMARY KEY (HeroID, SuperpowerID),
 FOREIGN KEY (HeroID) REFERENCES Hero(HeroID)
 ON DELETE CASCADE
 ON UPDATE CASCADE,
 FOREIGN KEY (SuperpowerID) REFERENCES Superpower(SuperpowerID)
 ON DELETE CASCADE
 ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS Villain_Superpowers (
 VillainID INT,
 SuperpowerID INT,
 PRIMARY KEY (VillainID, SuperpowerID),
 FOREIGN KEY (VillainID) REFERENCES Villain(VillainID)
 ON DELETE CASCADE
 ON UPDATE CASCADE,
 FOREIGN KEY (SuperpowerID) REFERENCES Superpower(SuperpowerID)
 ON DELETE CASCADE
 ON UPDATE CASCADE
);
