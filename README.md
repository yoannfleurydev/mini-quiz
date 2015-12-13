# MINI-QUIZ

## REQUIREMENTS

The following requirements were tested.
The application may be working on other configuration.
Just give it a try.

* `libcurl` installed on your system.
* Apache >= 2.4
* PHP >=5.4 on your web server **and** in your `PATH`. The following extensions are required :
    * `php5-curl`
    * `php5-json`
* MySQL >= 5.6 to run you database. `mysql` command should be in your `PATH`.

## INSTALLATION

1. Download the zip archive and extract the content of the mini-quiz folder, or just execute `git clone https://github.com/yoannfleurydev/mini-quiz.git`, into your **web server root**.
You should now see the `install.php` **file** into the root of your server.

2. Create the empty database in MySQL server.

3. Run `install.php` in **CLI** (**C**ommand **L**ine **I**nterface) and follow the steps.

        ~$ php install.php

4. Change the `require` line in `index.php` from  `require __DIR__ . '/../app/config/dev.php';` to `require __DIR__ . '/../app/config/prod.php';`

5. That's it! Enjoy Miniquiz!

## LICENCE

The content of this repository is under GPL Version 3 Licence.

## AUTHOR

  * [Valentin CROCHEMORE](mailto:valentin.crochemore1@etu.univ-rouen.fr)
  * [Yoann FLEURY](mailto:yoann.fleury@etu.univ-rouen.fr)
