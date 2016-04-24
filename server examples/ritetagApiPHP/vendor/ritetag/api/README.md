# README #

##[Browse the code](https://bitbucket.org/ritetag/ritetag-api-client/src/)##



##How to implement RiteTag API client##

###1. Create RiteTag developer account###
[Sign up for developer account here](https://ritetag.com/rest-api)



###2. Install via composer ###
```composer require ritetag/api:~2.0.0```


####3. Config ####
Edit config.sample and save as config.php to api folder

```
#!php
<?php
/*
 *  https://ritetag.com/developer/dashboard
 */
define('CONSUMER_KEY', '????');
define('CONSUMER_SECRET', '????');
define('OAUTH_TOKEN', "????");
define('OAUTH_TOKEN_SECRET',"????");

```