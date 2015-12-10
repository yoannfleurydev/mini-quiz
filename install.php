<?php

// TODO Ajouter les fonctions de suppression de fichier pour composer et le
// script de création de la base de données par exemple.


define("EXIT_SUCCESS", 0);
define("EXIT_FAILURE", 1);

$composer = "https://getcomposer.org/composer.phar";
$composerLocalPath = __DIR__ . "/composer.phar";
$mysqlScriptPath = __DIR__ . "/db/miniquiz.sql";

fprintf(STDOUT, "Bienvenue dans l'installation en ligne de commande du projet Miniquiz\n");
printMessage("TELECHARGEMENT DE COMPOSER EN COURS");

/***************************************/
/*    TELECHARGEMENT DE COMPOSER       */
/***************************************/
if (download($composer, $composerLocalPath)) {
    printMessage("INSTALLATION DES DEPENDANCES");

    exec('php composer.phar install');
} else {
    fprintf(STDOUT, "Le telechargement de Composer a echoue. Veuillez verifier votre connexion.");
    exit(EXIT_FAILURE);
}

/*****************************************/
/* INITIALISATION DE LA BASE DE DONNEES  */
/*****************************************/
if (PHP_OS == 'WINNT') {
    echo "Adresse de la base de donnees: ";
    $dbhost = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "Utilisateur base de donnees: ";
    $dbuser = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "Mot de passe de $dbuser: ";
    $dbpass = stream_get_line(STDIN, 1024, PHP_EOL);
    echo "Nom de la base de donnees: ";
    $dbname = stream_get_line(STDIN, 1024, PHP_EOL);
} else {
    $dbhost = readline("Adresse de la base de donnees: ");
    $dbuser = readline("Utilisateur de la base de données: ");
    $dbpass = readline("Mot de passe de $dbuser: ");
    $dbname = readline("Nom de la base de données: ");
}

printMessage("INITIALISATION DE LA BASE DE DONNEES");

$mysqlCommand = 'mysql'
    . ' --host=' . $dbhost
    . ' --user=' . $dbuser
    . ' --password=' . $dbpass
    . ' --database=' . $dbname
    . ' --execute="SOURCE ' . $mysqlScriptPath
;

$output = shell_exec($mysqlCommand);

printMessage("CREATION DE L'ADMINISTRATEUR DE MINIQUIZ");
// TODO


/* Fonctions */
function download($url, $path) {
    # open file to write
    $fp = fopen ($path, 'w+');
    # start curl
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    # set return transfer to false
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
    curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    # increase timeout to download big file
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
    # write data to local file
    curl_setopt( $ch, CURLOPT_FILE, $fp );
    # execute curl
    curl_exec( $ch );
    # close curl
    curl_close( $ch );
    # close local file
    fclose( $fp );

    return filesize($path) > 0;
}

function printMessage($message) {
    fprintf(STDOUT, "**********************************************************\n");
    fprintf(STDOUT, strtoupper($message) . "\n");
    fprintf(STDOUT, "**********************************************************\n");
}
