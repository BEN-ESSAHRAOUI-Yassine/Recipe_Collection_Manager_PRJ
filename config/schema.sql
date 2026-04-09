CREATE DATABASE IF NOT EXISTS recipe_repo;
USE recipe_repo;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(200) NOT NULL,
    role ENUM('admin','chef') DEFAULT 'chef',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    ingredients TEXT,
    instructions TEXT,
    prep_time INT,
    portions VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_user INT,
    id_category INT,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_category) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_recipe INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    UNIQUE (id_user, id_recipe),

    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_recipe) REFERENCES recipes(id) ON DELETE CASCADE
);

INSERT INTO categories (name) VALUES
('Dessert'),
('Main Course'),
('Salad'),
('Beverage');

INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@mail.com', '$2y$10$Nk2jaWseOPC9G6er/oh6MudzvMMdtLDlV.pkW/jIHZJAKXcSEQT.e', 'admin'),/*adminpass*/
('chef_ali', 'ali@mail.com', '$2y$10$yUoCxmuUpv5w7uTA/RRgDOuBaOPQow1J8kNDMXF1MLE90aXIuapxa', 'chef'),/*chefpass*/
('chef_sara', 'sara@mail.com', '$2y$10$yUoCxmuUpv5w7uTA/RRgDOuBaOPQow1J8kNDMXF1MLE90aXIuapxa', 'chef');

INSERT INTO recipes 
(title, ingredients, instructions, prep_time, portions, created_at, id_user, id_category)
VALUES
(
    'Chocolate Cake',
    'Flour, Sugar, Cocoa Powder, Eggs, Butter',
    'Mix ingredients, bake at 180°C for 30 minutes',
    45,
    '6 servings',
    NOW(),
    2,
    1
),
(
    'Grilled Chicken',
    'Chicken, Olive Oil, Garlic, Spices',
    'Marinate chicken and grill for 25 minutes',
    35,
    '4 servings',
    NOW(),
    2,
    2
),
(
    'Caesar Salad',
    'Lettuce, Croutons, Parmesan, Caesar dressing',
    'Mix all ingredients in a bowl',
    15,
    '2 servings',
    NOW(),
    3,
    3
),
(
    'Fresh Lemon Juice',
    'Lemons, Water, Sugar',
    'Squeeze lemons, mix with water and sugar',
    10,
    '3 glasses',
    NOW(),
    3,
    4
);
