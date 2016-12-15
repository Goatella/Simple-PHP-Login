Changes
=======

## SQL.txt is now table.sql

The file is now renamed to `table.sql` to take advantage of the editors highlighting. Other changes:

* `id` is now changed to `UNSIGNED` to avoid negative integers;
* `username` is now `UNIQUE`, to avoid conflicts and make the queries take advantage of index optimization;
* `password` and the other identifiers are now wrapped by backticks, main reason because **password** is a reserved word and it can prompt an error;
* engine is switched to `InnoDB` and charset to `utf8`.

## PHP files

Part of the scripts are written with `ext/mysql` which is deprecated up to PHP 5.6 and removed from PHP 7.0. There are some integrations with `ext/mysqli` but this locks the scripts to **MySQL** and, depending on the configuration, it can return unexpected results (I am talking about the differences between the **mysqlnd** and **libmysqlclient** libraries). To extend the range of supported databases, I'm proposing to switch to `PDO_MySQL` and adding a connection file: **pdo.php**.

See:

* http://php.net/manual/en/mysqlinfo.api.choosing.php
* http://php.net/manual/en/mysqlinfo.library.choosing.php

## Passwords

Passwords are now encrypted, not hashed with md5, has this is not a secure practice. See:

* http://php.net/manual/en/function.password-hash.php
* http://php.net/manual/en/function.password-verify.php
* https://www.owasp.org/index.php/Guide_to_Cryptography#How_to_determine_if_you_are_vulnerable

## Filtering the input

The requests are now filtered to avoid XSS and SQL injection attacks.

## Queries

Queries are performed through prepared statements, to avoid SQL injections.

## Errors

Errors are now logged by the PHP error log file.

## login.php

This script starts with the assumption that the user already logged will ship two cookies with username and password in plain text. This is highly unsafe. The script should not rely on cookies to allow the access but on session and check only if there is a valid session cookie and redirect the user to the user id contents associated with the session.

Also, the statement that checks if the cookie-password matches with the one in the database can generate and endless loop, because if the comparing `if ($pass != $info['password']){}` it will redirect back to the same page `else{header("Location: login.php");}`.

To avoid issues, whenever there is a valid session, the user should not be allowed to access the **login.php** and the **add.php** pages.