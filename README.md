# TAS
TAS: Student Activity Tracker based on Nette Framework.

## Version
Current version is V0.5 Beta stable.

## Installation setup
In a 4-step setup you can configure youre own TAS: Student Activity Tracker.
### Step 1 Get this repository
Get the content off this repository and save it on your harddrive in youre local-server environment, like htdocs-folder.
### Step 2 Install Nette/sandbox
Run composer update on the folder where you left this repository.
To do this run a terminal (unix/mac) or hit windowslogo and type cmd in search (win(7?))
Then in the termninal go in the TAS directory. Once in the TAS-dir type composer.phar update or composer update.
Composer should now update the directory to contain Nette/sandbox.
### Step 3 Add the database
In the folder TAS/DBDATA you will find a file calles tas.sql. Open this file and copy-paste the entire content to youre phpmyadmin-SQL-window.
It will automaticly add a database and fill it with te correct tables and settings. It will also automaticly create 3 basic-users for testing.

Username: student Password: 1234567 Username: monitor Password: 1234567 Username: admin Password: 1234567
### Step 4 Configure TAS
In the folder app/config/ you will find a file called config.local.neon.sample
Follow the instructions from the file and the system is good to go.
->There can be a problem with the dns-line of the file rejecting ''. If this occurs try replacing the '' with this '

## About
TAS is developed by [AMKuperus](https://github.com/AMKuperus) and [Guido Leijten](https://github.com/guidoleijten) as a project for [ITVitae](http://itvitae.nl/).

Nette Sandbox
=============

This is a simple pre-packaged and pre-configured application using the [Nette](https://nette.org)
that you can use as the starting point for your new applications.

[Nette](https://nette.org) is a popular tool for PHP web development.
It is designed to be the most usable and friendliest as possible. It focuses
on security and performance and is definitely one of the safest PHP frameworks.


Installation
------------

The best way to install Web Project is using Composer. If you don't have Composer yet,
download it following [the instructions](https://doc.nette.org/composer). Then use command:

	composer create-project nette/sandbox path/to/install
	cd path/to/install


Make directories `temp/` and `log/` writable.


Web Server Setup
----------------

The simplest way to get started is to start the built-in PHP server in the root directory of your project:

	php -S localhost:8000 -t www

Then visit `http://localhost:8000` in your browser to see the welcome page.

For Apache or Nginx, setup a virtual host to point to the `www/` directory of the project and you
should be ready to go.

It is CRITICAL that whole `app/`, `log/` and `temp/` directories are not accessible directly
via a web browser. See [security warning](https://nette.org/security-warning).


Requirements
------------

PHP 5.6 or higher. To check whether server configuration meets the minimum requirements for
Nette Framework browse to the directory `/checker` in your project root (i.e. `http://localhost:8000/checker`).


Adminer
-------

[Adminer](https://www.adminer.org/) is full-featured database management tool written in PHP and it is part of this Sandbox.
To use it, browse to the subdirectory `/adminer` in your project root (i.e. `http://localhost:8000/adminer`).


License
-------
- Nette: New BSD License or GPL 2.0 or 3.0
- Adminer: Apache License 2.0 or GPL 2
