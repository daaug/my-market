create database if not exists my_market;

use my_market;

create table if not exists product (
  id int auto_increment,
  name varchar(255),
  description varchar(255),
  price float(9,2),
  PRIMARY KEY (id)
);
