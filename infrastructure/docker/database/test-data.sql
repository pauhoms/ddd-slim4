drop table if exists user;
create table user
(
    id varchar(36) not null primary key,
    name varchar(200) not null,
    password varchar(255) not null,
    private_key varchar(255) not null
);
insert into user values ('id', 'name', 'password', 'test');
insert into user values ('id9', 'pau', 'password', 'test');