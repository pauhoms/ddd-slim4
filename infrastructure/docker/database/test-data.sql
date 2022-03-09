drop table if exists user;
create table user
(
    id varchar(36) not null primary key,
    name varchar(200) not null,
    password varchar(255) not null,
    private_key varchar(255) not null
);
insert into user values ('id', 'name', 'password', 'test');
insert into user values ('id9', 'pau', '$2y$12$fF7Q51uF/Fc1cCQD9/3VVefVUa5PW/Y.BdE/OIZdrNybq7FKjQTTK', 'test');