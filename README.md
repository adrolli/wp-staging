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
4) Create a subdomain to make the folder web-accessible
5) Login and start to manage your WordPress-Stages

## Todo

- class="text-center" on login-body
- display-flex on login-body
- footer in app?

- init platforms
  - live
    - wpconfig: d034dcf5:L7awkUC5z4Xa9
    - robots + htaccess
    - dump.sql search,replace,import
  - last
    - wpconfig: d034e7ed:G7VhgK8A6yFcTk6F
    - robots + htaccess
    - dump.sql search,replace,import
- live umbauen, contents ausdünnen
- .htaccess (und robots.txt) sichern
- tar wird nicht gelöscht in /backup
- plattform-kopie fehlt
- robots checken
- lock-funktion

- refactor (config outside, bootstrap locally, clean code)
- initialize new stage
  - create folder for new stage
  - copy source-stage
  - ENTER mysql://username:password@host:port/database
  - change values in wp-config.php, .htaccess, dump.sql
  - import sql-file to db
  - test stage availability
  - add stage to configuration
  - add "new stage" to stage-to dropdown
- better errorhandling / toast messages
- exclude tables (user driven content like comments, forms)
- exclude files (cache-folder?)

- Backup-Feature
- Staging-Feature
- Lock-Feature
- Robots-Feature
- Matomo-Feature (or hotfix)
- Restore-Feature
- feather - use or remove
- CSS-fix Card with iFrame
- Responsive Fixes
- Configuration-Feature, manage stages
- Exclude files or folders (cache)
- Manipulate settings (robots, debug)
- Skip tables @ import (user driven contents like comments)
- Search/Replace-Filter (replace specific settings, users, ...)
