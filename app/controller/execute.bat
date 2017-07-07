@Echo OFF

echo Saisir votre version de deploiement.
SET /p version=

echo Saisir le nom du repertoire GIT du client
SET /p name=

echo Liste des branch du dépot Hardis
git -C "D:/workspace/srv_deploiement/srv_hardis/OPCAIM" branch

echo Liste des branch du dépot du Client
git -C "D:/workspace/srv_deploiement/srv_client/OPCAIM" branch

echo Saisir le nom de votre branch :
SET /p env=

PHP ./push-git-recette.php version env

pause