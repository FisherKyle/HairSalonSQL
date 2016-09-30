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

        function test_getName()
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

        function test_getClient()
        {
        //Arrange
        $name = "Phillip FullofFruff";
        $stylist = "Scissors Armani";
        $new_client = new Client($name, $stylist);
        //Act
        $result = $new_client->getClient();
        //Assert
        $this->assertEquals($stylist, $result);
        }

        function test_getId()
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

        function test_save()
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

        function test_getAll()
        {
            //Arrange
            $name1 = "Phillip FullofFruff";
            $name2 = "Becca Bangs";
            $stylist1 = "Scissors Armani";
            $stylist2 = "Clipper McShay";
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

        function test_deleteAll()
        {
            //Arrange
            $name1 = "Phillip FullofFruff";
            $name2 = "Becca Bangs";
            $stylist1 = "Scissors Armani";
            $stylist2 = "Clipper McShay";
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

        function test_deleteOne()
        {
            //Arrange
            $name1 = "Phillip FullofFruff";
            $stylist1 = "Scissors Armani";
            $new_client1 = new Client($name1, $stylist1);
            $name2 = "Becca Bangs";
            $stylist2 = "Clipper McShay";
            $new_client2 = new Client($name2, $stylist2);
            $new_client1->save();
            $new_client2->save();
            $expected_output = [$new_client1];
            //Act
            $new_client2->deleteOne();
            $result = Client::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

        function test_update()
        {
            //arrange
            $name = "Phillip FullofFruff";
            $stylist = "Scissors Armani";
            $new_stylist = new Stylist($name, $client);
            $new_stylist->save();
            $updated_stylist = "Clipper McShay";
            $updated_client = "Becca Bangs";

            //act
            $new_stylist->update($updated_stylist, $updated_client);
            $all_clients = Client::getAll();
            $selected_client = $all_clients[0]->getName();
            $expected_output = $updated_name;

            //assert
            $this->assertEquals($expected_output, $result);
        }

    }
?>
