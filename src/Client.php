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

        function getClass()
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

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach ($returned_courses as $course)
            {
                $name = $course['name'];
                $stylist = $course['stylist'];
                $id = $course['C_Id'];
                $new_course = new Course($name, $stylist, $id);
            array_push($courses, $new_course);
            }
            return $courses;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (name, stylist) VALUES ('{$this->getName()}', '{$this->getClass()}')");
            $this->id = (int) $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
        }

        function update()
        {

        }

        static function find()
        {

        }

        function getStudent()
        {

        }



    }
?>
