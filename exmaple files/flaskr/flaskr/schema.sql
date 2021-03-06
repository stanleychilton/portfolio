drop table if exists entries;
create table entries (
  id integer primary key autoincrement,
  title text not null,
  'text' text not null
);
drop table if exists users;
create table users (
  id integer primary key autoincrement,
  firstname text not null,
  lastname text not null,
  username text not null,
  email text not null,
  password text not null
);