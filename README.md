TodoList - Application PHP avec Docker
📝 Description

Cette application est une TodoList simple développée en PHP avec une base de données MySQL, le tout conteneurisé avec Docker. Elle permet :
✅ Ajouter des tâches
✅ Afficher la liste des tâches
✅ Persister les données dans MySQL
⚙️ Prérequis

    Docker (Installation)

    Docker Compose

    MySQL 

🚀 Installation
1. Cloner le projet (si nécessaire)
sh

git clone https://github.com/visiteville/todolist-app.git
cd todolist-app

2. Démarrer les conteneurs

docker-compose up -d

    web : Serveur Apache/PHP (port 8080)

    db : MySQL 8.0 avec une base préconfigurée

3. Accéder à l'application

Ouvrez votre navigateur à l'adresse :
👉 http://localhost:8080
📂 Structure des fichiers
docker-compose.yml

Définit deux services :

    web (PHP/Apache)

        Build à partir de ./app/Dockerfile

        Port 8080 exposé

        Volume monté pour le développement (./app → /var/www/html)

        Dépend de db (attends que MySQL soit healthy)

    db (MySQL 8.0)

        Base de données tododb

        Utilisateur todo / Mot de passe todo-listpass

        Volume persistant pour les données (db_data)

        Script SQL d'initialisation (./mysql/init.sql)

./mysql/init.sql

Crée la table taches :
sql

CREATE TABLE IF NOT EXISTS taches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

./app/index.php

    Connexion à MySQL (db, todo, todopass, tododb)

    Ajout de tâches via un formulaire POST

    Affichage des tâches triées par date (DESC)

    Sécurisé :

        htmlspecialchars() pour éviter les attaques XSS

        Requêtes préparées contre les injections SQL

Interface (Bootstrap 5)

    Formulaire simple

    Liste des tâches en temps réel

🛠 Commandes utiles
Commande	Description
docker-compose up -d	Démarrer les conteneurs (détaché)
docker-compose down	Arrêter les conteneurs
docker-compose logs	Voir les logs
docker exec -it [NOM_CONTENEUR_DB] mysql -utodo -ptodopass tododb	Se connecter à MySQL
🔧 Personnalisation
Modifier la configuration MySQL

Éditez docker-compose.yml pour changer :
yaml

environment:  
  MYSQL_ROOT_PASSWORD: rootpass  
  MYSQL_DATABASE: tododb  
  MYSQL_USER: todo  
  MYSQL_PASSWORD: todopass  

Ajouter des fonctionnalités

    Supprimer une tâche : Ajouter un bouton avec DELETE FROM taches WHERE id=?

    Marquer comme terminée : Ajouter une colonne completed BOOLEAN
