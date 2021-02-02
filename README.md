# FileVine Connect Website

## DB Backup
The DB Backup history

## Reference
The two sources are api-collection and api-dashboard so we can reference how to use FileVine and the current logic/features.

### DB Structure
As the WP Plugin is more important than the website, we will design the DB based on WP's DB syntax and try to limit the number of tables as much as we can.

## FileVine Connect Website
client: http://filevine-connect.local/
admin: http://filevine-connect.local/admin


### How to Install
Just set up the local DB with the latest backup of DB Backup directory

### Notes
It just consists of PHP collects as the WordPress Plugin needs to reuse these codes.

- Two Admin templates and initial assets for Client and Admin are backup on 'Backup_full_assets' branch.
- On 'Master' branch, we will keep removing and cleaning up the assets and unnecessary php files.

For checking the full assets, please check https://github.com/wrappixel/monster-admin-lite and for a live demo, https://www.wrappixel.com/demos/free-admin-templates/monster-admin-lite/monster-html/index.html
