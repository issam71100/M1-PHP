Symfony & Anguar : Hitema M1 Module PHP1 Project
========================

TEAM : Tony PEREIRA, Victor FAU, Elias HAMADOUCHE, Issam KADAR, Flavien JARRY

Requirements
------------

  * PHP 7.1.3 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][2].

Install the symfony project
-----
### Clone the project 
#### By https
```bash
$ git clone https://github.com/pereira-tony/M1-PHP.git
```
####By ssh
```bash
$ git clone git@github.com:pereira-tony/M1-PHP.git
```

### Go Inside the project
```bash
$ cd M1-PHP
```
### Install composer dependencies
```bash
$ composer install
```

### Install Angular yarn dependencies
```bash
$ cd phpvoyage
$ yarn install
```

### Generate database (Important !!!!!!) => use only the folowing commands
```bash
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
```
Then import the data from the database in M1-PHP/data/database.sql


Launch the Symfony project
-----

There's no need to configure anything to run the application. If you have
installed the [Symfony client][4] binary, run this command to run the built-in
web server and access the application in your browser at <http://localhost:8000>:

```bash
$ symfony serve
```

If you don't have the Symfony client installed, run `php bin/console server:run`.
Alternatively, you can [configure a web server][3] like Nginx or Apache to run
the application.

Launch the Angular project
-----

There's no need to configure anything to run the application. If you have
installed the Angular Cli, run this command to run the built-in
web server and access the application in your browser at <http://localhost:4200>:

```bash
$ ng serve
```

If you don't have the  Angular Cli installed, run `npm install -g @angular/cli`.

Advancement
-----

The back-end of the project is finish. The Api contain verification of the arguments and an uploader of images was developped.

The font-end was not finish because of difficulties to recover the datas of the form. 
