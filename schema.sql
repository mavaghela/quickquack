drop table users;
drop table yaks;

create table users (
	username varchar(20) primary key,
	password varchar(20),
	firstName varchar(20), 
	lastName varchar(20),
	email varchar(50),
	bDay int,
	bMonth varchar(20),
	bYear int,
	gender varchar(20)
);

create table yaks (
	yakUser varchar(20),
	msg varchar(255),
	longitude Float, 
	latitude Float,
	time TIMESTAMP DEFAULT current_timestamp, 
	likes int,
	id serial
);