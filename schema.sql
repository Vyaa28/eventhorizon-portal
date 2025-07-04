-- DROP DATABASE IF EXISTS eventhorizon; -- optional, if re-creating
-- CREATE DATABASE eventhorizon;
-- USE eventhorizon;

CREATE TABLE Users (
    Id INT PRIMARY KEY IDENTITY(1,1),
    Email NVARCHAR(255) NOT NULL UNIQUE,
    Password NVARCHAR(255) NOT NULL,
    Role NVARCHAR(50) NOT NULL CHECK (Role IN ('organizer', 'attendee'))
);

CREATE TABLE Events (
    Id INT PRIMARY KEY IDENTITY(1,1),
    Title NVARCHAR(255),
    Description NVARCHAR(MAX),
    Date DATE,
    Location NVARCHAR(255),
    CreatedBy INT FOREIGN KEY REFERENCES Users(Id)
);

CREATE TABLE Registrations (
    Id INT PRIMARY KEY IDENTITY(1,1),
    UserId INT FOREIGN KEY REFERENCES Users(Id),
    EventId INT FOREIGN KEY REFERENCES Events(Id)
);
