<?php
  class Stylist
  {
    private $name;
    private $id;

    function __construct($name, $id=null)
    {
      $this->name = $name;
      $this->id =$id;
    }

// ---- GET * SET ---- //

    function getName(){
        return $this->name;
    }

    function getId(){
      return $this->id;
    }

    function setName($new_name){
      $this->name = (string) $new_name;
    }

// ---- FURTHER FUNCTIONALITY ---- //

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
    }

    function update($new_name)
    {
      $GLOBALS['DB']->exec("UPDATE stylists SET name = '{$new_name}' WHERE id = {$this->getId()};");
      $this->setName($new_name);
    }

    static function getAll()
    {
      $found_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
      $stylists = array();
      foreach($found_stylists as $stylist)
      {
        $name = $stylist['name'];
        $id = $stylist['id'];
        $new_stylist = new Stylist($name, $id);
        array_push($stylists, $new_stylist);
      }
      return $stylists;
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM stylists;");
    }

    static function find($search_id)
    {
      $found_stylist = null;
      $stylists = Stylist::getAll();
      foreach($stylists as $stylist)
      {
        $stylist_id = $stylist->getId();
        if ($stylist_id == $search_id)
        {
          $found_stylist = $stylist;
        }
      }
      return $found_stylist;
    }

    function getClients()
    {
      $clients = array();
      $found_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist = {$this->getId()};");
      foreach($found_clients as $client)
      {
        $name = $client['name'];
        $stylist = $client['stylist'];
        $id = $client['id'];
        $new_client = new Client($name, $stylist, $id);
        array_push($clients, $new_client);
      }
      return $clients;
    }
  }
?>
