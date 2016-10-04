<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
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
            $name = "Scissors Armani";
            $new_stylist = new Stylist($name);
            //Act
            $result = $new_stylist->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $id = 2;
            $name = "Scissors Armani";
            $new_stylist = new Stylist($name, $id);
            $expected_output = 2;
            //Act
            $result = $new_stylist->getId();
            //arrange
            $this->assertEquals($expected_output, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Scissors Armani";
            $new_stylist = new Stylist($name);
            //Act
            $new_stylist->save();
            $all_stylists = Stylist::getAll();
            $result = $all_stylists[0];
            //Assert
            $this->assertEquals($new_stylist, $result);
        }

        function test_getAll()
        {
            //Arrange
            $name1 = "Phillip Fulfruff";
            $name2 = "Becca Bangs";
            $new_stylist1 = new Stylist($name1);
            $new_stylist1->save();
            $new_stylist2 = new Stylist($name2);
            $new_stylist2->save();
            $expected_output = [$new_stylist1, $new_stylist2];
            //Act
            $result = Stylist::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name1 = "Phillip Fulfruff";
            $name2 = "Becca Bangs";
            $new_stylist1 = new Stylist($name1);
            $new_stylist1->save();
            $new_stylist2 = new Stylist($name2);
            $new_stylist2->save();
            $expected_output = [];
            //Act
            Stylist::deleteAll();
            $result = Stylist::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

        function test_deleteOne()
        {
            //Arrange
            $name1 = "Phillip Fulfruff";
            $new_stylist1 = new Stylist($name1);
            $name2 = "Becca Bangs";
            $new_stylist2 = new Stylist($name2);
            $new_stylist1->save();
            $new_stylist2->save();
            $expected_output = [$new_stylist1];
            //Act
            $new_stylist2->deleteOne();
            $result = Stylist::getAll();
            //Assert
            $this->assertEquals($expected_output, $result);
        }

        function test_updateName()
        {
            //arrange
            $name = "Scissors Armani";
            $new_stylist = new Stylist($name);
            $new_stylist->save();
            $updated_name = "Clipper McShay";

            //act
            $new_stylist->updateName($updated_name);
            $all_stylists = Stylist::getAll();
            $result = $all_stylists[0]->getName();

            //assert
            $this->assertEquals($updated_name, $result);
        }

        function test_find()
            {
                //Arrange
                $name1 = "Scissors Armani";
                $name2 = "Clipper McShay";
                $name3 = "Ned";
                $new_stylist1 = new Stylist($name1);
                $new_stylist1->save();
                $new_stylist2 = new Stylist($name2);
                $new_stylist2->save();
                $new_stylist3 = new Stylist($name3);
                $new_stylist3->save();
                //Act
                $result = Stylist::find($new_stylist3->getId());
                //Assert
                $this->assertEquals($new_stylist3, $result);
            }

            function test_getClients()
            {
              //Arrange
              $name1 = "Scissors Armani";
              $new_stylist1 = new Stylist($name1);
              $new_stylist1->save();
              $new_stylist1_id = $new_stylist1->getId();

              $name2 = "Clipper McShay";
              $new_stylist2 = new Stylist($name2);
              $new_stylist2->save();
              $new_stylist2_id = $new_stylist2->getId();

              $client1 = "Phillip Fulfruff";
              $new_client1 = new Client($client1, $new_stylist1_id);
              $new_client1->save();

              $client2 = "Becca Bangs";
              $new_client2 = new Client($client2, $new_stylist2_id);
              $new_client2->save();

              $client3 = "Moonstone Goatee";
              $new_client3 = new Client($client3, $new_stylist1_id);
              $new_client3->save();
              //Act
              $result = $new_stylist1->getClients();
              //Assert
              $this->assertEquals([$new_client1, $new_client3], $result);
            }
    }
?>
