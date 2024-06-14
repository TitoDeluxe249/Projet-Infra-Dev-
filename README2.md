Pour configurer l'environnement de développement pour notre plateforme de réservation en ligne de vols d'avion en PHP, suivez ces étapes :

**1. Installation de WAMPPSERVER**

    1 - Téléchargement de WAMPP SERVER :

        Rendez-vous sur le site officiel de WAMPP : https://wampserver.aviatechno.net/
        Téléchargez la version appropriée pour votre système d'exploitation (Windows, macOS, Linux).

    2 - Installation de WAMPP SERVER :

        Exécutez le fichier d'installation téléchargé et suivez les instructions pour installer WAMPP.


**2. Configuration de Composer**

    1 - Téléchargement de Composer :

        Rendez-vous sur le site officiel de Composer : https://getcomposer.org/
        Suivez les instructions pour installer Composer sur votre système.

    2 - Installation de Composer :

        Sur Windows, téléchargez et exécutez l'installateur de Composer.
        Sur macOS et Linux, vous pouvez utiliser le terminal pour installer Composer en suivant les instructions fournies sur le site.

    3 - Vérification de l'installation de Composer :

        Ouvrez un terminal ou une invite de commande.
        Tapez composer --version pour vérifier que Composer est correctement installé et accessible.


**3. Création de la structure du projet**

    1 - Création des dossiers et fichiers nécessaires :

        Créez un dossier pour votre projet, par exemple reservation-system, dans le répertoire de votre choix (par exemple, dans le répertoire htdocs de XAMPP si vous utilisez Windows).

    2 - Initialisation de Composer dans le projet :

        Ouvrez un terminal ou une invite de commande.

        Naviguez vers le répertoire de votre projet

        Exécutez la commande suivante pour initialiser Composer :
        
            $ composer init

        Suivez les instructions à l'écran pour configurer le fichier composer.json de base. Vous pouvez accepter les valeurs par défaut pour la plupart des questions.

    3 - Ajout de l'autoload à Composer :

        Ouvrez le fichier composer.json créé.

        Ajoutez la section autoload comme suit :

        {
            "autoload": {
                "psr-4": {
                    "App\\": "src/"
                }
            }
        }

        Exécutez la commande suivante pour générer les fichiers d'autoload :

        $ composer dump-autoload


**4. Configuration de la base de données**
    
    1 - Accéder à phpMyAdmin :

        Ouvrez un navigateur web.
        Rendez-vous à l'adresse suivante : http://localhost/phpmyadmin/
        Cela ouvrira l'interface de gestion de base de données phpMyAdmin, qui est incluse avec WampServer.

    2 - Connectez-vous à MySQL :

        Utilisez les identifiants par défaut :
        Utilisateur : root
        Mot de passe : Laissez ce champ vide par défaut.

    3 - Création de la base de données :

        Dans phpMyAdmin, cliquez sur "Nouvelle base de données".
        Entrez le nom de la base de données, par exemple reservation_system_db.
        Cliquez sur "Créer".

    4 - Création des tables nécessaires :

        Sélectionnez la base de données reservation_system_db.

        Cliquez sur l'onglet "SQL".

        Entrez le script SQL suivant pour créer les tables