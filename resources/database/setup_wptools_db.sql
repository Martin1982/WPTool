CREATE TABLE version (id INTEGER PRIMARY KEY AUTOINCREMENT, resource VARCHAR, version VARCHAR);
INSERT INTO version (resource, version) VALUES ('database', '0.1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR, password VARCHAR);
INSERT INTO users (username, password) VALUES ('admin', 'admin');