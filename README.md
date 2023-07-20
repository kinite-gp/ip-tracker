# router
 IP switcher for bindshell or revarseshell
<hr>

[![PHP 8.2](https://img.shields.io/badge/PHP-8.2-yellow.svg)](https://www.php.net/downloads.php)
<hr>

## Setting up:
1 - This is a php program, so it is placed on the server<br>
2 - You need a database named switch<br>
3 - Create a table named "users" in your database<br>

    Make it as follows
    id => AUTO_INCREMENT - int
    username => NOT NULL - varchar
    password => NOT NULL - varchar

>And be sure to create two users in it !!!!!!!!

4 - Create a table named "configs" in your database<br>

    Make it as follows
    id => AUTO_INCREMENT - int
    ip => NOT NULL - varchar
    port => NOT NULL - varchar
    username => NOT NULL - varchar
    datetime => NOT NULL - varchar

## How do we work?

- You can reach your goal by requesting this file
- Send the data as a post as below

- The output of the request sent with the following data:First, if there is user and pass in users, the login is done and return is the list of all the configurations stored in the database 
```json
{
  "user" : "The user stored in the users table",
  "pass" : "Password of that user",
  "mode" : "get_list_server"
}
```
- The output of the sent request with the following data: First, if there is a user and pass in the users, the login is done and the saved information returns the username.```json

```json
{
  "user" : "The user stored in the users table",
  "pass" : "Password of that user",
  "mode" : "get_in_server",
  "username" : "One of the usernames in the 'configs' table"
}
```
- The output of the sent request with the following data: First, if there is user and pass in 'users', the login is done and the rest of the data is stored in 'configs'.
```json
{
    "mode" : "send_to_server",
    "user" : "user in users",
    "pass" : "pass in users",
    "username" : "example",
    "password" : "1534",
    "ip" : "232.235.622.112",
    "port" : "345",
    "datetime" : "232323232323"
}
```