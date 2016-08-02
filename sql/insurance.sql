DROP DATABASE if EXISTS petInsurance;
CREATE DATABASE petInsurance;
USE petInsurance;


DROP TABLE if EXISTS Policies;
CREATE TABLE Policies (
  policyId          int(11) NOT NULL AUTO_INCREMENT,
  totalAmount       int(10) ,
  policyNumber      int(11) NOT NULL COLLATE utf8_unicode_ci,
  startDate			date,
  endDate			date,
  active  			boolean NOT NULL COLLATE utf8_unicode_ci,
  paymentOption		varchar(255) COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (policyId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE if EXISTS Users;
CREATE TABLE Users (
  userId                          int(11)              NOT NULL AUTO_INCREMENT,
  userName                        varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  password                        varchar(255)         NOT NULL COLLATE utf8_unicode_ci,
  firstName                       varchar(255)         NOT NULL COLLATE utf8_unicode_ci,
  lastName                        varchar(255)         NOT NULL COLLATE utf8_unicode_ci,
  gender                          VARCHAR(6)           NOT NULL COLLATE utf8_unicode_ci,
  birthday                        varchar(15)          NOT NULL COLLATE utf8_unicode_ci,
  ssn                             varchar(12) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  email                           varchar(255) COLLATE utf8_unicode_ci,
  phoneNumber                     varchar(255) COLLATE utf8_unicode_ci,
  isPrimaryPolicyHolder           boolean              NOT NULL COLLATE utf8_unicode_ci,
  relationWithPrimaryPolicyHolder varchar(10)          NOT NULL COLLATE utf8_unicode_ci,
  policyId                        int(11)COLLATE utf8_unicode_ci,
  active                          boolean              NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    				  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (userId),
  FOREIGN KEY (policyId) REFERENCES Policies(policyId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE if EXISTS Pets;
CREATE TABLE Pets (
  petId             int(11) NOT NULL AUTO_INCREMENT,
  policyId  		int(11) COLLATE utf8_unicode_ci,
  breed             varchar(255) COLLATE utf8_unicode_ci,
  species           varchar(255) COLLATE utf8_unicode_ci,
  birthdate			varchar(10) NOT NULL COLLATE utf8_unicode_ci,
  color             varchar(255) COLLATE utf8_unicode_ci,
  length            varchar(255) COLLATE utf8_unicode_ci,
  height            varchar(255) COLLATE utf8_unicode_ci,
  weight            varchar(255) COLLATE utf8_unicode_ci,
  name              varchar(255) COLLATE utf8_unicode_ci,
  sex               varchar(255) COLLATE utf8_unicode_ci,
  active  			boolean NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (petId),
  FOREIGN KEY (policyId) REFERENCES Policies(policyId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS CareTakers;
CREATE TABLE CareTakers (
  petId  		       int(11)  NOT NULL COLLATE utf8_unicode_ci,
  userId  		       int(11)  NOT NULL COLLATE utf8_unicode_ci,
  isPrimaryOwner  	   boolean  NOT NULL COLLATE utf8_unicode_ci,
  active  			   boolean  NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    	   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (petId)  REFERENCES Pets(petId),
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS UserAddresses;
CREATE TABLE UserAddresses (
  addressId         int(11) NOT NULL AUTO_INCREMENT,
  userId  		    int(11) COLLATE utf8_unicode_ci,
  address           varchar(255) COLLATE utf8_unicode_ci,
  city              varchar(255) COLLATE utf8_unicode_ci,
  zipcode           varchar(5) COLLATE utf8_unicode_ci,
  state             varchar(2) COLLATE utf8_unicode_ci,
  isPetAddress  	boolean NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (addressId),
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS Bills;
CREATE TABLE Bills (
  billId            int(11) NOT NULL AUTO_INCREMENT,
  dueDate    		date,
  policyId          int(11) COLLATE utf8_unicode_ci,
  minimumPayment    varchar(255) COLLATE utf8_unicode_ci,
  status            varchar(255) COLLATE utf8_unicode_ci,
  balance           varchar(8) COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (billId),
  FOREIGN KEY (policyId) REFERENCES Policies(policyId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS PaymentDetails;
CREATE TABLE PaymentDetails (
  paymentDetailsId        int(11) NOT NULL AUTO_INCREMENT,
  billId  			      int(11) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  firstName			      varchar(255) NOT NULL COLLATE utf8_unicode_ci,
  lastName			      varchar(255) NOT NULL COLLATE utf8_unicode_ci,
  debitOrCredit           varchar(255) COLLATE utf8_unicode_ci,
  cardType                varchar(255) COLLATE utf8_unicode_ci,
  cardNumber              varchar(255) COLLATE utf8_unicode_ci,
  zipCode        		  varchar(5) COLLATE utf8_unicode_ci,
  expirationDate          date,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (paymentDetailsId),
  FOREIGN KEY (billId) REFERENCES Bills(billId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS Admins;
CREATE TABLE Admins (
  adminId        int(11) NOT NULL AUTO_INCREMENT,
  userName				varchar(80) NOT NULL UNIQUE COLLATE utf8_unicode_ci,
  password 	varchar(80) NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (adminId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS ChangeStatusOfPet;
CREATE TABLE ChangeStatusOfPet (
  id          int(11) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id) REFERENCES Pets(petId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS ChangeStatusOfPolicy;
CREATE TABLE ChangeStatusOfPolicy (
  id          int(11) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id) REFERENCES Policies(policyId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS ChangeStatusOfBill;
CREATE TABLE ChangeStatusOfBill (
  id          int(11) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id) REFERENCES Bills(billId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE if EXISTS ChangeStatusOfUser;
CREATE TABLE ChangeStatusOfUser (
  id          int(11) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  dateCreated    	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO Policies (policyId, totalAmount, policyNumber, startDate, endDate, active, paymentOption) VALUES 
	   (1, 600, 1, '2015-04-05', '2015-10-05',0, '6');
INSERT INTO Policies (policyId, totalAmount, policyNumber, startDate, endDate, active, paymentOption) VALUES 
	   (2, 600, 1, '2015-10-05', '2016-04-05',1, '6'); 
INSERT INTO Policies (policyId, totalAmount, policyNumber, startDate, endDate, active, paymentOption) VALUES 
	   (3, 600, 2, '2015-03-05', '2015-09-05',0, '1');
INSERT INTO Policies (policyId, totalAmount, policyNumber, startDate, endDate, active, paymentOption) VALUES 
	   (4, 1200, 3, '2015-11-05', '2016-05-05',1, '1');
INSERT INTO Policies (policyId, totalAmount, policyNumber, startDate, endDate, active, paymentOption) VALUES 
       (5, 600, 4, '2015-11-05', '2016-05-05',1, '1');
	   
INSERT INTO Users (userId, policyId, userName, password, firstName, lastName, gender, birthday, ssn, email, phoneNumber, relationWithPrimaryPolicyHolder,isPrimaryPolicyHolder, active) VALUES 
	   (1,2,'superman', 'glasses', 'clark', 'kent','male', '1994-01-01','111111111','supes@hotmail.com','555-555-5555', 'none',1,1);
INSERT INTO Users (userId, policyId, userName, password, firstName, lastName, gender, birthday, ssn, email, phoneNumber, relationWithPrimaryPolicyHolder,isPrimaryPolicyHolder, active) VALUES 
	   (2,3,'flash', 'glasses', 'barry', 'allen','male', '1992-01-01','111111222','flash@hotmail.com','111-555-1111', 'none',1,0);
INSERT INTO Users (userId, policyId, userName, password, firstName, lastName, gender, birthday, ssn, email, phoneNumber, relationWithPrimaryPolicyHolder,isPrimaryPolicyHolder, active) VALUES 
	   (3,4,'maryj', 'spidey', 'mary', 'jane','female', '1993-01-01','111113333','mary@hotmail.com','123-534-1111', 'spouse',0,1);
INSERT INTO Users (userId, policyId, userName, password, firstName, lastName, gender, birthday, ssn, email, phoneNumber, relationWithPrimaryPolicyHolder,isPrimaryPolicyHolder, active) VALUES 
	   (4,4,'spiderman', 'spider', 'peter', 'parker','male', '1992-06-01','1132411222','spider@hotmail.com','234-555-1111', 'none',1,0);
INSERT INTO Users (userId, policyId, userName, password, firstName, lastName, gender, birthday, ssn, email, phoneNumber, relationWithPrimaryPolicyHolder,isPrimaryPolicyHolder, active) VALUES 
	   (5,5,'green', 'lantern', 'hal', 'jordan','male', '1994-06-01','32434323422','green@hotmail.com','243-432-1111', 'none',1,1);
	   
INSERT INTO Pets (petId, policyId, breed, species, birthdate, color, length, height, weight, name, sex, active) VALUES 
	   (1, 2, 'maine coon', 'cat', '2010-01-01','brown','56','20','22', 'snowball', 'male',1);
INSERT INTO Pets (petId, policyId, breed, species, birthdate, color, length, height, weight, name, sex, active) VALUES 
	   (2, 3, 'rottweiler', 'dog', '2009-01-01','black','65','32','89', 'rotty', 'male',0);
INSERT INTO Pets (petId, policyId, breed, species, birthdate, color, length, height, weight, name, sex, active) VALUES 
	   (3, 4, 'cocker spaniel', 'dog', '2011-01-01','white','43','33','22', 'daisy', 'male',1);
INSERT INTO Pets (petId, policyId, breed, species, birthdate, color, length, height, weight, name, sex, active) VALUES 
	   (4, 4, 'golden retriever', 'dog', '2012-01-01','blond','56','43','76', 'goldy', 'female',1);
INSERT INTO Pets (petId, policyId, breed, species, birthdate, color, length, height, weight, name, sex, active) VALUES 
	   (5, 5, 'mutt', 'dog', '2012-01-01','blond','56','43','76', 'mutty', 'female',1);
INSERT INTO Pets (petId, policyId, breed, species, birthdate, color, length, height, weight, name, sex, active) VALUES 
	   (6, 5, 'mutt', 'dog', '2012-01-01','blond','56','43','76', 'rutty', 'female',1);
	   
INSERT INTO CareTakers (petId, userId, isPrimaryOwner, active) VALUES 
	   (1, 1, 1, 1); 
INSERT INTO CareTakers (petId, userId, isPrimaryOwner, active) VALUES 
	   (2, 2, 1, 0); 
INSERT INTO CareTakers (petId, userId, isPrimaryOwner, active) VALUES 
	   (3, 3, 0, 1); 
INSERT INTO CareTakers (petId, userId, isPrimaryOwner, active) VALUES 
	   (3, 4, 1, 1);
INSERT INTO CareTakers (petId, userId, isPrimaryOwner, active) VALUES 
	   (4, 3, 0, 1); 
INSERT INTO CareTakers (petId, userId, isPrimaryOwner, active) VALUES 
	   (4, 4, 1, 1);
INSERT INTO CareTakers (petId, userId, isPrimaryOwner, active) VALUES 
	   (5, 5, 1, 1);	   
	   
INSERT INTO UserAddresses (addressId, userId, address, city, zipcode, state, isPetAddress) VALUES 
	   (1, 1, '555 blah', 'San Antonio','78240', 'TX',0);
INSERT INTO UserAddresses (addressId, userId, address, city, zipcode, state, isPetAddress) VALUES 
	   (2, 1, '353 wayne', 'San Antonio','78245', 'TX',1);
INSERT INTO UserAddresses (addressId, userId, address, city, zipcode, state, isPetAddress) VALUES 
	   (3, 2, '543 Blvd', 'New York','43243', 'NY',1);
INSERT INTO UserAddresses (addressId, userId, address, city, zipcode, state, isPetAddress) VALUES 
	   (4, 3, '222 way', 'Salt Lake City','84101', 'UT',1);
INSERT INTO UserAddresses (addressId, userId, address, city, zipcode, state, isPetAddress) VALUES 
	   (5, 4, '222 way', 'Salt Lake City','84101', 'UT',1);
INSERT INTO UserAddresses (addressId, userId, address, city, zipcode, state, isPetAddress) VALUES 
	   (6, 5, '234 way', 'Salt Lake City','84101', 'UT',1);
	   
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (1, '2015-04-05', 1, '100','ontime', '600');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (2, '2015-05-05', 1, '100','ontime', '500');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (3, '2015-06-05', 1, '100','ontime', '400');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (4, '2015-07-05', 1, '100','ontime', '300');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (5, '2015-08-05', 1, '100','ontime', '200');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (6, '2015-09-05', 1, '100','ontime', '100');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (7, '2015-10-05', 2, '100','ontime', '600');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (8, '2015-11-05', 2, '100','ontime', '500');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (9, '2015-12-05', 2, '100','pending', '400');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (10, '2015-03-05', 3, '600','ontime', '600');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (11, '2015-11-05', 3, '1200','ontime', '600');
INSERT INTO Bills (billId, dueDate, policyId, minimumPayment, status, balance) VALUES 
	   (12, '2015-11-05', 5, '600','late', '600');
	   
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (1, 1, 'Clark', 'Kent','debit', 'visa','1111111111111','11111','2020-01-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (2, 2, 'Clark', 'Kent','debit', 'visa','1111111111111','11111','2020-01-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (3, 3, 'Clark', 'Kent','debit', 'visa','1111111111111','11111','2020-01-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (4, 4, 'Clark', 'Kent','debit', 'visa','1111111111111','11111','2020-01-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (5, 5, 'Clark', 'Kent','debit', 'visa','1111111111111','11111','2020-01-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (6, 6, 'Clark', 'Kent','credit', 'chase','1342111543111','11111','2020-01-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (7, 7, 'Clark', 'Kent','debit', 'visa','1111111111111','11111','2020-01-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (8, 8, 'Clark', 'Kent','debit', 'visa','1111111111111','11111','2020-01-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (9, 10, 'Barry', 'Allen','credit', 'master card','1435111111453','12345','2015-05-01');
INSERT INTO PaymentDetails (paymentDetailsId, billId, firstName, lastName, debitOrCredit, cardType, cardNumber, zipCode, expirationDate) VALUES 
	   (10, 11, 'Peter', 'Parker','credit', 'master card','5555111111555','23346','2022-05-01');
	   
	   
INSERT INTO Admins(adminId, userName, password)VALUES
       (1,'admin','password');
       
       
DROP VIEW if EXISTS overDueBills;
create view overDueBills as
SELECT firstName, lastName, dueDate, balance, bills.status,startDate, endDate, policies.policyId
FROM `bills` inner JOIN policies on bills.policyId = policies.policyId inner join users on policies.policyId = users.policyId 
WHERE status = "late" and users.active = 1 and policies.active = 1 and users.isPrimaryPolicyHolder = 1;

DROP VIEW if EXISTS numOfUsers;
create view numOfUsers as
SELECT
policyNumber,
count(policies.policyId) as policyCount
FROM policies
group by policyNumber;

DROP VIEW if EXISTS policyDetails;
create view policyDetails as
SELECT policies.policyNumber, count(DISTINCT users.userId) as userCount, count(DISTINCT pets.petId) as petCount, policyCount 
FROM `policies`,pets, users,numofusers 
WHERE policies.policyId = pets.policyId and users.policyId = policies.policyId and numofusers.policyNumber = policies.policyNumber 
group by policies.policyNumber