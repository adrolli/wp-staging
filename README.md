# W-I-P - WordPress Staging Manager

Work in progress, do not use!

## Installation

1) Copy all files to your webserver. The best possible place is in row with your stages like this:
```
|- livestage-webroot
|- devstage-webroot
|- thirdstage-webroot
|- stage-manager <- put the files in there
```
2) Copy config-example.php to config.php
3) Adjust settings in config.php (Username, Passwort, Stages and Paths)
4) Create a subdomain (e. g. staging.yours.com) to make the folder web-accessible
5) Login and start to manage your WordPress-Stages (e. g. https://staging.yours.com)

## Todo

- Backup-Feature
- Restore-Feature
- Stage-Feature
- Robots-Feature
- Matomo-Feature (or hotfix)
- .htaccess (und robots.txt) sichern
- tar wird nicht gelöscht in /backup
- plattform-kopie fehlt
- robots checken
- initialize new stage
  - create folder for new stage
  - copy source-stage
  - ENTER mysql://username:password@host:port/database
  - change values in wp-config.php, .htaccess, dump.sql
  - import sql-file to db
  - test stage availability
  - add stage to configuration
  - add "new stage" to stage-to dropdown
- logging and better errorhandling / toast messages
- feather - use or remove
- CSS-fix Card with iFrame
- Responsive Fixes
- Configuration-Feature, manage stages
- Substages and more platforms (typo3, laravel etc.)
- Exclude files or folders (cache)
- Manipulate settings (robots, debug)
- Skip tables @ import (user driven contents like comments)
- Search/Replace-Filter (replace specific settings, users, ...)