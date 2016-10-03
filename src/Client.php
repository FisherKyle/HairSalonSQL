<?php
    class Client
    {
        private $name;
        private $stylist;
        private $id;

        function __construct($name, $stylist, $id = null)
            {
                $this->name = $name;
                $this->stylist = $stylist;
                $this->id = $id;
            }

// ---- GET * SET ---- //

        function getName()
        {
            return $this->name;
        }

        function getStylist()
        {
            return $this->stylist;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setStylist($new_stylist)
        {
            $this->stylist = (string) $new_stylist;
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
                $stylist = $client['stylist'];
                $new_client = new Client($name, $stylist, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        function save()
        {
          $GLOBALS['DB']->exec("INSERT INTO clients (name, stylist) VALUES ('{$this->getName()}', {$this->getStylist()});");
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

        function update($new_client)
        {
          $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_client}' WHERE id = {$this->getId()};");
          $this->setName($new_client);
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
    }
?>
