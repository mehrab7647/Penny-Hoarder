
-- 1. Clean up tables from Lab 8 if present
DROP TABLE IF EXISTS Loggers, Logins;

-- 2. Create the Loggers Table
CREATE TABLE Loggers(
        user_id INT NOT NULL AUTO_INCREMENT,
        first_name VARCHAR(25),
        last_name VARCHAR(25),
        username VARCHAR(50),
        password VARCHAR(50),
        dob DATE,
        avatar_url VARCHAR(50),
        PRIMARY KEY (user_id)
    ); 

-- 3. Create the Logins table
CREATE TABLE Logins(
        login_id INT NOT NULL AUTO_INCREMENT,
        user_id INT,
        login_time DATETIME,
        ip_address VARCHAR(15),
        PRIMARY KEY (login_id),
        FOREIGN KEY (user_id) REFERENCES Loggers(user_id)
    );

