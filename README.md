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


### function _KLogin()_

Cette fonction se charge de l'affichage du formulaire de login.
La fonction charge le template du formulaire et l'envoie dans un retour `formLogin`.

### function _KLogout()_

Cette fonction se charge de déconnecter l'utilisateur.
La fonction supprime les données de l'utilisateur dans la session et envoie un retour `logout` qui affiche une boite de dialogue qui confirme le logout de l'utilisateur

### function _authentication()_

Cette fonction se charge de l'authentification de l'utilisateur. La fonction reçoit un utilisateur en paramètre, 
récupère les profils de l'utilisateur, crée les droits de l'utilisateur et stocke toutes 
les données en session.

#### Paramètres

`array $user` : tableau contenant les informations concernant l'utilisateur

#### Return

`int` : Retourne `-1` si l'utilisateur est en cours d'activation <br>
`void` : Envoie une action `userConnu` avec les données du user

### function _sendMakeTable()_

Envoie un array à l'action `makeTable`. Cela affiche le tableau passé en paramètre en HTML5 dans la zone `#contenu`.

#### Paramètres

`array $tab` : Tableau à envoyer au JS

### function _callResAjax()_

Appelle la fonction ajax mise à disposition dans les ressources de Delvigne. Les requêtes non supportées par notre 
application passeront par cette fonction.

#### Paramètres

`string $rq` : Requête demandée

### function  _chargeTemplate()_

Charge le fichier de template dont le nom est passé en paramètre. Le fichier doit se trouver dans le dossier :file_folder: INC/ et 
avoir un nom commencant par `template.` et se terminant par `.inc.php`.<br>
La fonction renvoie false si le fichier n'existe pas.

#### Paramètres

`string $name` : Nom du fichier de template à charger

#### Return

`string` : Renvoie le contenu du fichier de template <br>
`bool` : Renoie `false` si le fichier n'existe pas

### function _tpSem05()_

Dans cette fonction se trouvent tous les envois nécessaires au fonctionnement du formulaire du tp5.<br>
La fonction charge le template du formulaire tp5 (cfr. `chargeTemplate()`).
La fonction fait un appel à la procédure `allGroups` et renvoie les données dans l'action `data`.
Ces 'data' servent à remplir le sélecteur de groupes dans le formulaire.



## :page_facing_up: droits.inc.php

:file_folder: /INC/droits.inc.php

Cette librairie permet de gérer les droits des utilisateurs et de générer les menus selon les droits. 
Ce fichier est protégé, il ne peut être ouvert directement et doit être inclu par le fichier index. 

### function _isAuthenticated()_

Vérifie qu'un utilisateur est connecté. 

#### Return

`bool` : Renvoie `true` si un utilisateur est connecté.

### function _isAdmin()_

Vérifie si l'utilisateur à un profil Administrateur.

#### Return

`bool` : Renvoie `true` si un utilisateur ayant le profil Administrateur est connecté

### function _isSousAdmin()_

Vérifie si l'utilisateur à un profil Sous-administrateur.

#### Return

`bool` : Renvoie `true` si un utilisateur ayant le profil Sous-administrateur est connecté

### function _isReactiv()_

Vérifie si l'utilisateur a le status de réactivation.

#### Return 

`bool` : Renvoie `true` si un utilisateur au status réactivation est connecté

### function _isMdpp()_

Vérifie si l'utilisateur a le status de mot de passe perdu.

#### Return

`bool` : Renvoie `true` si un utilisateur au status de mot de passe perdu est connecté

### function _isEdit()_

Vérifie si l'utilsateur à les droits d'édition pour les informations du site. (Fonction non utilisée).

#### Return

`bool` : Renvie `true` si l'utilisateur est Administrateur ou n'est pas en réactivation

### function _creeDroits()_

Crée les droits de l'utilisateur en fonction de son profils et de ses status et stocke ces droits en session.

#### Return

`int` : Renvoie `-1` si l'utilisateur n'est pas authentifié<br>
`int` : Renvoie `-2` si l'utilisateur n'est pas en réactivation ou si l'utilisateur est Administrateur

### function _creeMenu()_

Génère dynamiquement les menus à afficher en fonction du profil et des status de l'utilisateur.

`string` : Renvoie une chaine de caractères contenant les menus à afficher au format HTML5



## :page_facing_up: config.inc.php

Classe Config : 

- Gère la récupération de configuration depuis des fichiers `.ini`
- Gère la génération d'un formulaire HTML5 pour modifier la config
- Gère la sauvegarde dans un fichier `.ini ` de la nouvelle config

### Attribut `$filename`

Nom du ficher de configuration.<br>
**Valeurs :** null | string

### Attribut `$fileExist`

Vrai si le fichier de config existe.<br>
**Valeurs :** bool

### Attribut `$config`

Tableau multidimensionnel contenant la configuration un fois chargée.<br>
**Valeurs :** array

### Attribut `$saveError`

Contient les erreurs rencontrées durant le processus de sauvegarde.<br>
**Valeurs :** int

### function ___construct()_

Constructeur de la classe Config.<br>
Si il reçoit un filename en paramètre, il le stocke dans l'attribut et vérifie son existance.

#### Paramètres

`string filename` : Nom du fichier de config. (Optionnel)

### function _getFilename()_

Getter du filename. <br>
Retourne le nom du fichier de configuration. 

#### Return

`null` : Pas de nom de fichier enregistré
`string` : Le nom du fichier

### function _isFileExist()_

Getter de l'attribut fileExist.<br>

#### Return 

`bool` : Renvoie `true` si le fichier de config existe
`bool` : Renvoie `false` si le fichier de config n'existe pas

### function _getConfig()_

Getter de la configuration.<br>
Renvoie un tableau multidimensionnel de la configuration actuellement chargée. 

#### Return

`array` : La configuration<br>
`string` : Si aucune configuration chargée, Renvoie `Config non chargée`

### function _getSaveError()_

Getter de l'attribut saveError. <br>
Renvoie une valeur différente de zéro si le processus de sauvegarde a rencontré une erreur. 

#### Return 

`int` : Le numéro de l'erreur

### function _load()_

Charge le fichier de config demandé dans l'attribut config. <br>
La fonction va soit chargé la config du fichier stocké dans l'attribut filename, soit le fichier passé en paramètre. 

#### Paramètres

`string filename` : Nom du fichier de config à charger. (Optionnel)

#### Return

`array` : Renvoie la config si le chargement s'est bien passé <br>
`bool` : Renvoie `false` si la fonction de lecture du fichier a rencontré une erreur <br>
`string` : Renvoie un string si le fichier de config n'existe pas. <br>

### function _save()_

Sauvegarde la nouvelle configuration (contenue dans `$_POST`) à l'emplacement demandé.<br>
Si une erreur est rencontrée durant le processus, renvoie une chaine avec l'erreur. 

#### Paramètres

`string filename` : Fichier dans lequel sauvegarder la config

#### Return

`string` : Le message d'erreur

### function _getForm()_

Génère dynamiquement un formulaire en se basant sur le fichier de config actuellement chargé. <br>

#### Return

`string` : Renvoie une chaine de caractère contenant le formulaire HTML5

### function _getBloc()_

Génère les différents blocs du formulaire. 

#### Paramètres

`string k` : Nom du bloc <br>
`array v` : Tableau des éléments de ce bloc

#### Return

`array` : Renvoie un tableau des lignes du blocs généré

### function _saveErrorMessage()_

Retourne le bon message d'erreur selon le numéro passé en paramètre.

#### Paramètres

`int error` : Numéro de l'erreur

#### Return

`string` : Message d'erreur



## :page_facing_up: db.inc.php

Classe DB :

- Gère la connection à la base de données
- Gère les appels de procédures

### Attribut `$db`

Contient les informations de connection de la DB depuis la config.<br>
**Valeurs :** array

### Attribut `$pdoException`

Contient les exceptions renvoyées par la connexion à la DB.<br>
**Valeurs :** Exception | PDOException

### Attribut `$iPdo`

Contient l'instance de l'objet PDO.<br>
**Valeurs :** PDO

### fucntion ___construct()_

Constructeur de la classe DB.<br>
Initialise la connection à la DB sur base des infos de connexion venant de la config. 

### function _getException()_

Gettre de l'attribut pdoException.<br>
Renvoie l'exception catché durant la connextion à la BD ou le call de procédure. 

#### Return 

`string` : Le message de l'exception

### function _getServer()_

Retourne le serveur sur lequel l'application tourne actuellement. 

#### Return

`string` : Renvoie `localhost` ou l'adresse ip du serveur 

### function _call_v1()_

Effectue un call à la procédure `mc_allGroups`. 

#### Return 

`array` : Retour de la procédure

### function _call()_

Effectue un call intelligent avec les paramètres passé à la fonction. 

#### Paramètres

`string name` : Nom de la procédure à appeler<br>
`array param` : Tableau contenant les paramètres à passer à la procédure (Optionnel)

#### Return

`array` : Retour de la procédure


## :page_facing_up: sender.inc.php

Cette librairie gère l'envoi actions au JS.

### function _display()_

Affiche la chaine passée en paramètre dans la zone `#contenu` du site. 

#### Paramètres

`string txt` : Chaine de caractère à afficher

### function _error()_

Affiche la chaine passée en paramètre dans la zone `#error` du site.

#### Paramètres 

`string txt` : Chaine de caractère à afficher

### function _debug()_

Affiche la chaine passée en paramètre dans la zone `#debug` du site. 

#### Paramètres

`string txt` : Chaine de caractère à afficher

### function _kint()_

Affiche la chaine passée en paramètre dans la zone `#kint` du site. <br>
La paramètre de cette fonction doit **TOUJOURS** être un retour de la fonction `d()` de la librairie kint. 

#### Paramètres 

`string txt` : Retour de la fonction `d()`

### function _toSend()_

Fonction d'envoie d'informations vers JS au retour de l'appel AJAX. <br>

#### Paramètres

`string txt` : Chaine de caractère à transmettre. <br>
`string action` : Action à laquelle transmettre la chaine. Par defaut, action `display`.



## :page_facing_up: index.js

Script JS du site. Tout le traitement côté client du site est géré dans ce fichier. 

### function _gereRetour()_

Fonction de callback de l'appel AJAX. <br>
Gère les retours envoyé par la fonction `toSend` de PHP.<br>
Toutes les actions sont gérées dans cette fonction. 

**Liste des actions supportées :**

Action | Description
-------|------------
cacher | Cache le contenu dont le selecteur est passé dans le retour
montrer | Affiche le contenu dont le selecteur est passé dans le retour
layout | Met à jour le titre et le logo du site après un changement dans la config
newMenu | Remplace l'ancien menu par le nouveau généré par la fonction PHP `creeMenu`
formTP05 | Affiche le formulaire TP05 et gère l'évênementiel lié à ce formulaire
formConfig | Affiche le formulaire de config et gère l'évênementiel du formulaire
formLogin | Affiche le formulaire de connexion et gère l'évênementiel du formulaire
userConnu | Appelée à la connexion de l'utilisateur, Affiche un message de bienvenue
logout | Supprime les datas liés à l'utilisateur, Affiche de message de confirmation
peutPas | Affiche une boite de dialogue lorsque l'utilisateur n'a pas le droit d'effectuer une action
estRéac | Appelée si l'utilisateur est en cours de réactivation, Affiche un bandeau avec le message passé dans le retour
display | Affiche l'élément passé dans le retour dans la zone `#contenu` du site
kint, debug, error | Affiche le texte passé en paramètre dans la zone correspondant à l'action
makeTable | Construit une table HTML5 avec le tableau passée dans le retour et l'affiche dans la zone `#contenu`
jsonError | Affiche l'erreur dans la zone `#jsonError` du site
data | Récupère et stocke les données pour l'action formTP05
default | Affiche un message en console avec l'action et son contenu

#### Paramètres

`string retour` : Données envoyées par PHP au format JSON.

### function _appelAjax()_

Envoie une requête AJAX à la page `index.php` et envoie la requête demandée en GET

#### Paramètres

`string elem` : Requête à effectuer au format `<request>.html`

### function _testeJson()_

Récupère le JSON passé en paramètre et le parse en objet JS.<br>
Si le parse échoue, renvoie l'erreur à l'action jsonError.

#### Paramètres

`string json` : Le JSON à parser et tester

#### Return

`obj` : La structure de donnée en retour du parse

### function _makeOptions()_

Construit une liste d'options HTML5 (select). 

#### Paramètres

`array list` : Liste d'options <br>
`string value` : Clé de la liste à utiliser pour la valeur de l'option <br>
`string displayTxt` : Clé de la liste à utiliser comme texte à afficher dans l'option <br>

#### Return

`string` : Chaine de caractère contenant le select HTML5

### function _makeTableFromObject()_

Crée un tableau HTML5 sur base d'un tableau d'objets passé en paramètre

#### Paramètres

`array tab` : Tableau d'objet

#### Return 

`string` : Tableau HTML5

### function _makeTableFromArray()_

Crée un tableau HTML5 sur base d'un tableau de tableau passé en paramètre.

#### Paramètres

`array tab`: Tableau de tableau

#### Return

`string` : Tableau HTML5

### function _makeTheadObject()_

Crée le Thead d'un tableau HTML5 pour des objets.

#### Paramètres

`string el` : Titre de la colonne <br>
`array type` : Détermine le type d'élément dans le tableau <br>

#### Return

`string` : Thead HTML5

### function _makeTheadArray()_

Crée le Thead d'un tableau HTML5 pour des arrays.

#### Paramètres

`string el` : Titre de la colonne <br>
`array type` : Détermine le type d'élément dans le tableau <br>

#### Return

`string` : Thead HTML5

### function _makeTbody()_

Crée le Tbody d'un tableau HTML5 pour un array.

#### Paramètres

`array tab` : Tableau des données du tableau <br>
`string type` : Type de structure de données

### function _makeTable()_

Crée un tableau HTML5 sur base du tableau passé en paramètre.

#### Paramètres

`array tab` : Tableau de données

#### Return

`string` : Tableau HTML5

### function _filtrage()_

Fonction événementielle. <br>
Filtre les groupes en fonction de l'input dans une barre de recherche. <br>
Effectue la cherche sur le début, le milieu ou la fin de la chaine selon la radiobox sélectionnée.
