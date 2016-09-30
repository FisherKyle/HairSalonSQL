<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__."/../src/Salon.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use($app){
        return $app['twig']->render('home.html.twig');
    });

    $app->get("/clients_page", function() use($app){
        return $app['twig']->render('clients_page.html.twig', array('clients' => Client::getAll(), 'stylists' => Stylist::getAll()));
    });

    $app->get("/stylists_page", function() use($app){
        return $app['twig']->render('stylists_page.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/added_client", function() use ($app)
    {
      $new_client = new Client($_POST(['name'], ['stylist_id']));
      $new_client->save();
      return $app['twig']->render('clients.html.twig', array('clients' =>Client::getAll()));
    });

    $app->post("/added_stylist", function() use ($app)
    {
      $new_stylist = new Stylist($_POST['name']);
      $new_stylist->save();
      return $app['twig']->render('stylists_page.html.twig', array('stylists' =>Stylist::getAll()));
    });





?>