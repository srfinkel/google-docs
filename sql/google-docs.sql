DROP TABLE IF EXISTS collaborators;
DROP TABLE IF EXISTS document;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId      INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileEmail   VARCHAR(128)                NOT NULL,
	profileHash CHAR(128)                   NOT NULL,
	profileSalt CHAR(64)                    NOT NULL,
	UNIQUE(profileEmail),
	PRIMARY KEY(profileId)
);

CREATE TABLE document (
	documentId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	documentProfileId INT UNSIGNED NOT NULL,
	documentContent MEDIUMTEXT,
	documentTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	INDEX(documentProfileId),
	PRIMARY KEY(documentId)
);

CREATE TABLE collaborators (
	collaboratorProfileId INT UNSIGNED NOT NULL,
	collaboratorDocumentId INT UNSIGNED NOT NULL,
	INDEX(collaboratorProfileId),
	INDEX(collaboratorDocumentId),
	FOREIGN KEY(collaboratorProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(collaboratorDocumentId) REFERENCES document(documentId),
	PRIMARY KEY(collaboratorProfileId, collaboratorDocumentId)
);