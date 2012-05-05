CREATE TABLE version (id INTEGER PRIMARY KEY AUTOINCREMENT, resource VARCHAR, version FLOAT);
INSERT INTO version ('', 'database', 0.1);

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username VARCHAR, password VARCHAR);
INSERT INTO users ('', 'admin', 'admin');