# SITEX - Documentation

## :page_facing_up: index.php 

:file_folder: /index.php

Fichier d'entrée de l'application. 
Toutes les requêtes passent par là.
Ce fichier se charge de démarer la session, charger la bonne configuration, créer les droits de l'utilisateur actuellement loggé, etc

## :page_facing_up: request.inc.php

:file_folder: /INC/request.inc.php

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
gestLog        | Connecte ou déconnecte l'utilisateur
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

**Liste des formulaires supportés :**

Formulaire  | Action
------------|-----------
formTP05    | Récupère dans la DB, les cours pour le groupe sélectionné et renvoie une action `makeTable` au JS
modifConfig | Sauve la nouvelle config dans le fichier, reloade la nouvelle config dans la Session et envoie les changements dans l'action `layout`
formLogin   | Vérifie que le username et mot de passe sont corrects et authentifie l'utilisateur (cfr. `authentication`)


### function _peutPas()_

Cette fonction détermine si un utilisateur à le droit d'éffectuer une requête en se basant sur la liste de droits liée à l'utilisateur `$_SESSION['droits']`. 
Dans le cas où l'utilisateur n'as pas le droit, on bloque l'exécution de la requête et on envoie une boite de dialogue à l'utilisateur via l'action `peutPas`.<br>
On gère aussi les cas où l'utilisateur est en cours de réactivation, une boite de diablogue différente est alors envoyée à l'utilisateur 

#### Paramètres

`string $req` : requête de l'utilisateur veut éffectuer

#### Return

`boolean` : Renvoie `TRUE` si l'utilisateur **NE PEUT PAS** éffectuer la requête.<br>
`boolean` : Renvoie `FALSE` si l'utilisateur **A LE DROIT** d'éffectier la requête. 