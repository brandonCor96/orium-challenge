# orium-challenge
## How to run the app with Lando (Docker):
```bash
#First install Lando
https://docs.lando.dev/getting-started/installation.html

#Start Lando
lando start

#After that the app is runing. To check info: 
lando info

#You'll see the URL to visit
http://orium-challenge.lndo.site/

#To Stop Lando
lando stop
```

## Database Import:
To import the database, please run the next command:
```bash
lando db-import db/backup.sql.gz
```

## Composer install and Config import :
To run the project and get all the config files synced, please run:
```bash
#install all the dependencies
lando composer install

#Import all the configs
lando drush cim

#Clear cache
lando drush cr
```
## Access as Superadmin
```bash
#Run this command to access as Superadmin, and open the link
lando drush uli
```

## Pages to visit
Page ---
## Tech Stack:

**Drupal 9**

## Authors

- [@brandonCor96](https://github.com/brandonCor96)