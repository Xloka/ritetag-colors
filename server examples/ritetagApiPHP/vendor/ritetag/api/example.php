<!DOCTYPE html>
<html>
    <head>
        <title>Ritetag - Rest API</title>
    </head>
    <body>
        <div class="page">
            <h1>Ritetag rest API</h1>

            <?php
            error_reporting(E_ALL);
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors', 1);

            require_once 'vendor/autoload.php';
            /*
             * configuration
             */
            if (file_exists('config.php')) {
                require_once 'config.php';
                $client = new \Ritetag\API\Client(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
                echo ($client->hashtagStats("test")->getBody());
                echo "<hr>";
                $client->returnRequest();
                echo ($client->hashtagStats("test")->to_url());
            } else {
                ?>
                <div class="alert alert-danger" role="alert">Missing configuration file config.php (you can copy config.sample.php and fill your auth tokens from <a href="https://ritetag.com/developer/dashboard">developers dashboard</a>)</div>
            <?php }
            ?>

        </div>

    </body>
</html>