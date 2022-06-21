#!/bin/sh

crontab -u www-data /var/www/cron/tasks
crontab -u www-data -l
crond -b -l 8
php ./app.php configure
spiral serve -v -d -c ./.rr.yaml

