Europass CEDEFOP
=======================

Introduction
------------
This is a simple Europass Cedefop module for understand how the Services and RESTful services works in Zend Framework 2.

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies

    cd var/www/europass
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

<VirtualHost *:80>
    ServerName europass.it
    ServerAlias www.europass.it
    DocumentRoot /Library/WebServer/Documents/europass/public
    SetEnv APPLICATION_ENV "development"
    <Directory /Library/WebServer/Documents/europass/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
