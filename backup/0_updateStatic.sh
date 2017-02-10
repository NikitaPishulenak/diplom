#!/bin/sh


#d=`date +%H`;
#ts=`date +%H_%M_%d`;




/usr/bin/php -q /var/www/html/createHtml_cron.php
touch /`date +%H_%M_%d`.txt






#if [[ $d -eq 09 ]];then
#    statupdate
#fi;


# test if
#if [[ $d -eq 14 ]]; then
#    statupdate
#fi;


#if [[ $d -eq 17 ]]; then
#    statupdate
#fi;

#if [[ $d -eq 18]]; then
#    statupdate
#fi;

