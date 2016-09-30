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
        return $app['twig']->render('home.html.twig', array('clients'=>Client::getAll(), 'stylists'=>Stylist::getAll()));
    });

    $app->get("/clients_page", function() use($app){
        return $app['twig']->render('clients_page.html.twig');
    });

    $app->get("/stylists_page", function() use($app){
        return $app['twig']->render('stylists_page.html.twig');
    });

    $app->post("/add_client", function() use ($app){
        $name=$_POST['client_name'];
        $stylist=$_POST['stylist_name'];
        $new_client=new Client($name, $stylist);
        $new_client->save();
    });

    $app->post("/add_stylist", function() use($app){
        $name=$_POST['stylist_name'];
        $
    })


?>
