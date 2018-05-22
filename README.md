# SITEX - Documentation

## index.php 

📁 /index.php

Fichier d'entrée de l'application. 
Toutes les requêtes passent par là.
Ce fichier se charge de démarer la session, charger la bonne configuration, créer les droits de l'utilisateur actuellement loggé, etc

## request.inc.php

📁 /INC/request.inc.php

Regroupe des fonctions de gestion des requêtes, des droits, de l'authentification.

### function _gereRequete()_

Fonction gereRequete: toutes les requètes venant du JS passe par ici. <br>
La fonction reçoit une requête en paramètre qui est évaluée dans la liste des requêtes prises en charges

**Liste des requêtes supportées :**

Requête        | Action
---------------|-------------
sem04          | Affiche un message dans le `#contenu` du site
sem03          | Affiche un message dans le `#contenu` du site
TPsem05        | Retourne le formulaire du TP05
gestLog        | Connecte et déconnecte l'utilisateur
formSubmit     | Redirige vers la gestion de formulaire
displaySession | Affiche en `#debug` le contenu de la session 
clearLog       | Clear les logs stoskés dans la session
resetSession   | Destroy et redémarre une nouvelle session
config         | Load le fichier de config et renvoie le formulaire
testDB         | Effectue plusieurs appels de procédure en DB pour tester son fonctionnement

#### Paramètres

`string $rq` : requête provenant du JS

#### Return

`int` : La fonction retourne -1 si l'utilisateur n'as pas le droit d'éffectuer une action <br>
`void` : La fonction ne retourne rien le reste du temps

### function _gereSubmit()_

Cette fonction gère tous les différents formulaires du site. <br>
Tous les formulaires du site ont leur action qui renvoit vers la requête `gereSubmit`. On récupère le `senderId` dans cette fonction, 
ce qui nous permet de déterminer quel traitement effectuer parmis les formulaires supportés. 