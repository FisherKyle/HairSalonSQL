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

        function setClass($new_stylist)
        {
            $this->stylist = (string) $new_stylist;
        }
//NOTE may have to fix for each loop --
        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach ($returned_stylists as $stylist)
            {
                $name = $client['name'];
                $stylist = $client['stylist'];
                $id = $client['C_Id'];
                $new_course = new Course($name, $stylist, $id);
            array_push($stylists, $new_appointment);
            }
            return $stylists;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (name, stylist) VALUES ('{$this->getName()}', '{$this->getStylist()}')");
            $this->id = (int) $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
        }

        function update()
        {

        }

        static function find()
        {

        }




    }
?>
