<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";
    date_default_timezone_set('America/New_York');

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use($app){
        return $app['twig']->render('home.html.twig');
    });


//========================STYLIST=============================//
//============================================================//

    $app->get("/stylists_page", function() use($app){
        return $app['twig']->render('stylists_page.html.twig', array('stylists' => Stylist::getAll()));
    });

// add new stylists ---------- //

    $app->post("/stylist_list", function() use ($app){
        $new_stylist = new Stylist($_POST['stylist_name']);
        $new_stylist->save();
        return $app['twig']->render('stylists_page.html.twig', array('stylists' =>Stylist::getAll()));
    });

// render stylist info on details page -------- //

    $app->get("/stylist_details/{id}", function($id) use ($app){
        $stylist = Stylist::find($id);
        $stylist_clients = $stylist->getClients();
        return $app['twig']->render('stylist_details.html.twig', array(
            'current_stylist' => $stylist, 'stylist_clients' => $stylist_clients ));
    });

// delete one stylist

    $app->get("/stylist_list/{id}/delete", function ($id) use ($app){
        $stylist = Stylist::find($id);
        $stylist->deleteOne();
        return $app['twig']->render('stylists_page.html.twig', array('stylists' => Stylist::getAll()));
    });

// delete all stylist

$app->post("/stylist_delete_all", function () use ($app){
    Stylist::deleteAll();
    return $app['twig']->render('stylists_page.html.twig', array('stylists' => Stylist::getAll()));
});

// update stylist's name ----------- //

$app->patch("/stylist_details/{id}", function($id) use ($app){
    $stylist_name=$_POST['stylist_update'];
    $stylist=Stylist::find($id);
    $stylist->updateName($stylist_name);
    return $app['twig']->render('stylist_details.html.twig', array('current_stylist' => $stylist, 'stylist_clients' => Client::getAll()));
});

// update client of stylist's name ----------- //

$app->patch("/stylist_details/{id}", function($id) use ($app) {
  $client_name = $_POST['client_update'];
  $client = Stylist::find($id);
  $client->updateName($client_name);
  return $app['twig']->render('stylist_details.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
});

// add new client to stylist ---------- //

    $app->post("/stylist_details/{id}", function($id) use ($app){
        $stylist = Stylist::find($id);
        $added_client = new Client($_POST['client-name'], $stylist->getId());
        $added_client->save();
        $stylist_clients = $stylist->getClients();
        return $app['twig']->render('stylist_details.html.twig', array(
            'current_stylist' => $stylist, 'stylist_clients' => $stylist_clients ));
    });

// delete one client from stylist ---------------------- //

    $app->get("/client_details/{id}/{stylist_id}/delete", function ($id, $stylist_id) use ($app){
        $client = Client::find($id);
        $client->deleteOne();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist_details.html.twig', array('current_stylist' => $stylist, 'stylist_clients' => Client::getAll()));
    });

// delete all clients from stylist ---------------- //

$app->post("/stylist_delete_clients/{id}", function ($id) use ($app){
    $stylist = Stylist::find($id);
    Client::deleteAll();
    return $app['twig']->render('stylist_details.html.twig', array('current_stylist' => $stylist));
});

//=========================ClIENT=============================//
//============================================================//


// // add new client ------------------ //
//
//     $app->post("/client_list", function() use ($app){
//         $new_client = new Client($_POST['client_name'], $_POST['stylist_id']);
//         $new_client->save();
//         return $app['twig']->render('clients_page.html.twig', array('clients' => Client::getAll()));
//     });

// update client name ----------------- //

    $app->get("/client_list/{id}", function($id) use ($app){
        $client = Client::find($id);
        $client->updateName($_POST['client_name']);
        return $app['twig']->render('clients_page.html.twig', array('clients' => Client::getAll()));
    });

    return $app;
?>
