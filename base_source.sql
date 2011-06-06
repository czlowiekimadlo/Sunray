

create table config (
	id int not null auto_increment,
	attribute text,
	value text,
	module int default 0,
	primary key(id)
);

insert into config(attribute, value) values('title_separator', ' :: ');
insert into config(attribute, value) values('title', 'Perfect House Solutions');
insert into config(attribute, value) values('template', 'default');

insert into config(attribute, value) values('smtp_use', '0');
insert into config(attribute, value) values('smtp_mail', '');
insert into config(attribute, value) values('smtp_host', '');
insert into config(attribute, value) values('smtp_port', '');
insert into config(attribute, value) values('smtp_user', '');
insert into config(attribute, value) values('smtp_pass', '');



create table session(
	id char(32) not null,
	data text,
	access timestamp not null,
	primary key (id)
);

create table users(
	id int not null auto_increment,
	login text,
	password text,
	lvl int default 0,
	active int not null default 0,
	primary key(id)
);

insert into users(login, password, lvl) values('admin', '098f6bcd4621d373cade4e832627b4f6', 0);

create table posts(
	id int not null auto_increment,
	user int,
	title text,
	content text,
	allowed tinying default 0,
	created timestamp default current_timestamp,
	expiry timestamp,
	category int default 0,
	primary key(id)
);
