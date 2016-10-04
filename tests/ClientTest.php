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

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

// ----Tests---- //

        function test_getName()
        {
            //Arrange
            $name = "Phillip Fulfruff";
            $stylist_id = 1;
            $new_client = new Client($name, $stylist_id);
            //Act
            $result = $new_client->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getStylistId()
        {
        //Arrange
        $name = "Phillip Fulfruff";
        $stylist_id = 1;
        $new_client = new Client($name, $stylist_id);
        //Act
        $result = $new_client->getStylistId();
        //Assert
        $this->assertEquals($stylist_id, $result);
        }

        function test_getId()
        {
            //Arrange
            $id = 2;
            $name = "Phillip Fulfruff";
            $stylist_id = 3;
            $new_client = new Client($name, $stylist_id, $id);
            $expected_output = 2;
            //Act
            $result = $new_client->getId();
            //arrange
            $this->assertEquals($expected_output, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Phillip Fulfruff";
            $stylist_id = 1;
            $new_client = new Client($name, $stylist_id);
            //Act
            $new_client->save();
            $all_clients = Client::getAll();
            $result = $all_clients[0];
            //Assert
            $this->assertEquals($new_client, $result);
        }

        function test_getAll()
        {
            //Arrange
            $name1 = "Phillip Fulfruff";
            $name2 = "Becca Bangs";
            $stylist_id1 = 1;
            $stylist_id2 = 2;
            $new_client1 = new Client($name1, $stylist_id1);
            $new_client1->save();
            $new_client2 = new Client($name2, $stylist_id2);
            $new_client2->save();
            $expected_output = [$new_client1, $new_client2];
            //Act
            $result = Client::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name1 = "Phillip Fulfruff";
            $name2 = "Becca Bangs";
            $stylist_id1 = 1;
            $stylist_id2 = 2;
            $new_appointment1 = new Client($name1, $stylist_id1);
            $new_appointment1->save();
            $new_appointment2 = new Client($name2, $stylist_id2);
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
            $stylist_id1 = 1;
            $new_client1 = new Client($name1, $stylist_id1);
            $name2 = "Becca Bangs";
            $stylist_id2 = 2;
            $new_client2 = new Client($name2, $stylist_id2);
            $new_client1->save();
            $new_client2->save();
            $expected_output = [$new_client1];
            //Act
            $new_client2->deleteOne();
            $result = Client::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

        function test_updateName()
        {
            //arrange
            $name = "Phillip Nofruff";
            $stylist_id = 1;
            $new_client = new Client($name, $stylist_id);
            $new_client->save();
            $updated_name = "Phillip Fulfruff";

            //act
            $new_client->updateName($updated_name);
            $all_clients = Client::getAll();
            $expected_output = $updated_name;
            $result = $all_clients[0]->getName();


            //assert
            $this->assertEquals($expected_output, $result);
        }

        function test_switchProperty()
        {
            //arrange
            $name = "Phillip Fulfruff";
            $stylist_id = 1;
            $new_client = new Client($name, $stylist_id);
            $new_client->save();
            $switched_name = "Becca Bangs";
            $switched_stylist_id = 2;
            //act
            $new_client->switchProperty($switched_name, $switched_stylist_id);
            $expected_output = [$switched_name, $switched_stylist_id];
            $all_clients = Client::getAll();
            $returned_switched_name = $all_clients[0]->getName();
            $returned_switched_stylist_id = $all_clients[0]->getStylistId();
            $result = [$returned_switched_name, $returned_switched_stylist_id];
            //assert
            $this->assertEquals($expected_output, $result);
        }

        function test_find()
        {
          //Arrange
          $name = "Scissors Armani";
          $test_stylist = new Stylist($name);
          $test_stylist->save();
          $stylist_id = $test_stylist->getId();

          $name1 = "Becca Bangs";
          $name2 = "Phillip Fulfuff";
          $name3 = "Moonstone Goatee";
          $test_client1 = new Client($name1, $stylist_id);
          $test_client1->save();
          $test_client2 = new Client($name2, $stylist_id);
          $test_client2->save();
          $test_client3 = new Client($name3, $stylist_id);
          $test_client3->save();
          //Act
          $result = Client::find($test_client3->getId());
          //Assert
          $this->assertEquals($test_client3, $result);
        }

    }
?>
