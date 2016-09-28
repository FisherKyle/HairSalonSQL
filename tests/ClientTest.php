<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    stylist ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Stylist::deleteAll();
            Client::deleteAll();
        }

// ----Tests---- //

        function test_GetName()
        {
            //Arrange
            $name = "Phillip Fullfruff";
            $stylist = "Scissors Armani";
            $new_appointment = new Client($name, $stylist);
            //Act
            $result = $new_appointment->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_GetClass()
        {
        //Arrange
        $name = "Phillip FullofFruff";
        $stylist = "Scissors Armani";
        $new_appointment = new Client($name, $stylist);
        //Act
        $result = $new_appointment->getClass();
        //Assert
        $this->assertEquals($stylist, $result);
        }

        function test_GetId()
        {
            //Arrange
            $id = 2;
            $name = "Phillip FullofFruff";
            $stylist = "Scissors Armani";
            $new_stylist = new Client($name, $stylist, $id);
            $expected_output = 2;
            //Act
            $result = $new_stylist->getId();
            //arrange
            $this->assertEquals($expected_output, $result);
        }

        function test_Save()
        {
            //Arrange
            $name = "Phillip FullofFruff";
            $stylist = "Scissors Armani";
            $new_appointment1 = new Client($name, $stylist);
            $new_appointment1->save();
            //Act
            $result = Client::getAll();
            //Assert
            $this->assertEquals($new_appointment, $result[0]);
        }

        function test_GetAll()
        {
            //Arrange
            $name1 = "Phillip FullofFruff";
            $name2 = "Intro to Jerky";
            $stylist1 = "Scissors Armani";
            $stylist2 = "JRK_101";
            $new_appointment1 = new Client($name1, $stylist1);
            $new_appointment1->save();
            $new_appointment2 = new Client($name2, $stylist2);
            $new_appointment2->save();
            $expected_output = [$new_appointment1, $new_appointment2];
            //Act
            $result = Client::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

        function test_DeleteAll()
        {
            //Arrange
            $name1 = "Phillip FullofFruff";
            $name2 = "Intro to Jerky";
            $stylist1 = "Scissors Armani";
            $stylist2 = "JRK_101";
            $new_appointment1 = new Client($name1, $stylist1);
            $new_appointment1->save();
            $new_appointment2 = new Client($name2, $stylist2);
            $new_appointment2->save();
            $expected_output = [];
            //Act
            Client::deleteAll();
            $result = Client::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

        function test_DeleteOne()
        {
            //Arrange
            $name1 = "Phillip FullofFruff";
            $stylist1 = "Scissors Armani";
            $new_appointment1 = new Client($name1, $stylist1);
            $name2 = "Intro to Jerky";
            $stylist2 = "JRK_101";
            $new_appointment2 = new Client($name2, $stylist2);
            $new_appointment1->save();
            $new_appointment2->save();
            $expected_output = [$new_appointment1];
            //Act
            $new_appointment2->deleteOne();
            $result = Client::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

    }
?>
