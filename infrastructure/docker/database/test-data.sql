drop table if exists user;
create table user
(
    id varchar(36) not null primary key,
    name varchar(200) not null,
    password varchar(100) not null
);
