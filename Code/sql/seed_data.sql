INSERT INTO assignment.users (username, password, money, userEnabled, isAdmin)
    VALUES ("Admin", "e3afed0047b08059d0fada10f400c1e5", 30, true, true);

INSERT INTO assignment.users (username, password)
    VALUES ("Sammi", "42f749ade7f9e195bf475f37a44cafcb");

INSERT INTO assignment.users (username, password, userEnabled)
    VALUES ("John Doe", "42f749ade7f9e195bf475f37a44cafcb", false);

INSERT INTO assignment.items (ownersName, title, description, price)
    VALUES ("Admin", "House plants", "Some plants for home", 8.99);

INSERT INTO assignment.items (ownersName, title, description, price)
    VALUES ("Sammi", "Cookies", "Home made choc chip cookies", 5.5);

INSERT INTO assignment.test (id, name, age)
    VALUES (1, "Sam", 20);
