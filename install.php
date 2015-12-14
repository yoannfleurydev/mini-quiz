<?php

// TODO Ajouter les fonctions de suppression de fichier pour composer et le
// script de création de la base de données par exemple.


define("EXIT_SUCCESS", 0);
define("EXIT_FAILURE", 1);

$composer = "https://getcomposer.org/composer.phar";
$composerLocalPath = __DIR__ . "/composer.phar";
$mysqlScriptPath = __DIR__ . "/db/miniquiz.sql";

fprintf(STDOUT, "\nBienvenue dans l'installation en ligne de commande du projet Miniquiz\n\n");
printMessage("TELECHARGEMENT DE COMPOSER EN COURS");

/***************************************/
/*    TELECHARGEMENT DE COMPOSER       */
/***************************************/
if (download($composer, $composerLocalPath)) {
    printMessage("INSTALLATION DES DEPENDANCES");

    exec('php composer.phar install');
} else {
    fprintf(STDOUT, "Le telechargement de Composer a echoue. Veuillez verifier votre connexion.\n\n");
    exit(EXIT_FAILURE);
}

/*****************************************/
/* INITIALISATION DE LA BASE DE DONNEES  */
/*****************************************/

printMessage("INITIALISATION DE LA BASE DE DONNEES");

if (PHP_OS == 'WINNT') {
    echo "\nAdresse de la base de donnees: ";
    $dbhost = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "\nUtilisateur base de donnees: ";
    $dbuser = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "\nMot de passe de $dbuser: ";
    $dbpass = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "\nNom de la base de donnees: ";
    $dbname = stream_get_line(STDIN, 1024, PHP_EOL);
} else {
    $dbhost = readline("\nAdresse de la base de donnees: ");
    $dbuser = readline("\nUtilisateur de la base de données: ");
    $dbpass = readline("\nMot de passe de $dbuser: ");
    $dbname = readline("\nNom de la base de données: ");
}

$mysqlCommand = 'mysql'
    . ' --host=' . $dbhost
    . ' --user=' . $dbuser
    . ' --password=' . $dbpass
    . ' --database=' . $dbname
    . ' --execute="SOURCE ' . $mysqlScriptPath . ';"';
;

$output = shell_exec($mysqlCommand);

printMessage("CREATION DE L'ADMINISTRATEUR DE MINIQUIZ");
if (PHP_OS == 'WINNT') {
    echo "\nIdentifiant de connexion de l'administrateur de l'application: ";
    $admin_login = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "\nMot de passe de connexion de l'administrateur de l'application: ";
    $admin_password = stream_get_line(STDIN, 1024, PHP_EOL);
} else {
    $admin_login = readline("\nIdentifiant de connexion de l'administrateur de l'application: ");
    $admin_password = readline("\nMot de passe de connexion de l'administrateur de l'application: ");
}

$hashed_password = password_hash($admin_password, PASSWORD_BCRYPT, array('cost' => 11));

$mysqlCommand = 'mysql'
    . ' --host=' . $dbhost
    . ' --user=' . $dbuser
    . ' --password=' . $dbpass
    . ' --database=' . $dbname
    . ' --verbose'
    . ' --execute="INSERT INTO mq_user(user_login, user_password, user_access_id) VALUES(\''. $admin_login . '\', \'' .
    $hashed_password . '\', 1);"';

$output = shell_exec($mysqlCommand);

/* Fonctions */
function download($url, $path) {
    $fp = fopen ($path, 'w+');
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
    curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
    curl_setopt( $ch, CURLOPT_FILE, $fp );
    curl_exec( $ch );
    curl_close( $ch );
    fclose( $fp );

    return filesize($path) > 0;
}

function printMessage($message) {
    fprintf(STDOUT, "\n**********************************************************\n");
    fprintf(STDOUT, strtoupper($message) . "\n");
    fprintf(STDOUT, "**********************************************************\n\n");
}

function readline($prompt = null){
    if($prompt){
        echo $prompt;
    }
    $fp = fopen("php://stdin","r");
    $line = rtrim(fgets($fp, 1024));
    return $line;
}
