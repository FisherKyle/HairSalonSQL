<?php
    class Client
    {
        private $name;
        private $stylist_id;
        private $id;

        function __construct($name, $stylist_id, $id = null)
            {
                $this->name = $name;
                $this->stylist_id = $stylist_id;
                $this->id = $id;
            }

// ---- GET * SET ---- //

        function getName()
        {
            return (string) $this->name;
        }

        function getStylistId()
        {
            return (int) $this->stylist_id;
        }

        function getId()
        {
            return (int) $this->id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setStylistId($new_stylist_id)
        {
            $this->stylist_id = (int) $new_stylist_id;
        }

// ---- FURTHER FUNCTIONALITY ---- //

        static function getAll()
        {
            $all_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($all_clients as $client)
            {
                $name = $client['name'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($name, $stylist_id, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        function save()
        {
          $GLOBALS['DB']->exec("INSERT INTO clients (name, stylist_id) VALUES ('{$this->getName()}', {$this->getStylistId()});");
          $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

        function deleteOne()
        {
          $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }

        function updateName($new_client_name)
        {
          $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_client_name}' WHERE id = {$this->getId()};");
          $this->setName($new_client_name);
        }


        static function find($search_id)
        {
            $matching_client = null;
            $clients = Client::getAll();
            foreach($clients as $client)
            {
                $client_id = $client->getId();
                if ($client_id == $search_id)
                {
                    $matching_client = $client;
                }
            }
            return $matching_client;
        }

        function switchProperty($switched_client_name=null, $switched_stylist_id=null)
        {
            if ($switched_client_name != null) {
                $GLOBALS['DB']->exec("UPDATE clients SET name = '{$switched_client_name}' WHERE id = {$this->getId()};");
                $this->setName($switched_client_name);
            }
            if ($switched_stylist_id != null) {
                $GLOBALS['DB']->exec("UPDATE clients SET stylist_id = '{$switched_stylist_id}' WHERE id = {$this->getId()};");
                $this->setStylistId($switched_stylist_id);
            }
        }
    }

    //
    //     function switchStylist($new_id=null)
    //     {
    //         if ($new_id != null) {
    //                 $GLOBALS['DB']->exec("UPDATE clients SET stylist_id = '{$new_id}' WHERE id = {$this->getId()};");
    //                 $this->setStylistId($new_id);
    //             }
    //         }
    //
    // }
?>
