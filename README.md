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

- Backup-Feature
- Staging-Feature
- Lock-Feature
- Robots-Feature
- Matomo-Feature (or hotfix)
- feather - use or remove
- CSS-fix Card with iFrame
- Responsive Fixes
