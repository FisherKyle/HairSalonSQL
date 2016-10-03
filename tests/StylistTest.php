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
            $S_id = 1;
            $new_stylist = new Stylist($name, $S_id);
            //Act
            $result = $new_appointment->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getStylist()
        {
        //Arrange
        $name = "Scissors Armani";
        $client = "Phillip Fulfruff";
        $new_stylist = new Stylist($name, $client);
        //Act
        $result = $new_stylist->getStylist();
        //Assert
        $this->assertEquals($new_stylist, $result);
        }

        function test_getId()
        {
            //Arrange
            $id = 2;
            $name = "Scissors Armani";
            $client = "Phillip Fulfruff";
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
            $name1 = "Phillip Fulfruff";
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
            $name1 = "Phillip Fulfruff";
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
            $name1 = "Phillip Fulfruff";
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
            $name = "Scissors Armani";
            $new_stylist = new Stylist($name, $client);
            $new_stylist->save();
            $updated_stylist = "Clipper McShay";

            //act
            $new_stylist->update($updated_stylist);

            //assert
            $this->assertEquals($updated_stylist, $new_stylist->getName());
        }

        function test_find()
            {
                //Arrange
                $name1 = "Scissors Armani";
                $name2 = "Clipper McShay";
                $name3 = "Ned";
                $found_stylist1 = new Stylist($name1);
                $found_stylist1->save();
                $found_stylist2 = new Stylist($name2);
                $found_stylist2->save();
                $found_stylist3 = new Stylist($name3);
                $found_stylist3->save();
                //Act
                $result = Stylist::find($found_stylist3->getId());
                //Assert
                $this->assertEquals($found_stylist3, $result);
            }

            function test_getClients()
            {
              //Arrange
              $name1 = "Scissors Armani";
              $found_stylist1 = new Stylist($name1);
              $found_stylist1->save();
              $found_stylist1_id = $found_stylist1->getId();

              $name2 = "Clipper McShay";
              $found_stylist2 = new Stylist($name2);
              $found_stylist2->save();
              $found_stylist2_id = $found_stylist2->getId();

              $client1 = "Phillip Fulfruff";
              $found_client1 = new Client($client1, $found_stylist1_id);
              $found_client1->save();

              $client2 = "Becca Bangs";
              $found_client2 = new Client($client2, $found_stylist2_id);
              $found_client2->save();

              $client3 = "Moonstone Goatee";
              $found_client3 = new Client($client3, $found_stylist1_id);
              $found_client3->save();
              //Act
              $result = $found_stylist1->getClients();
              //Assert
              $this->assertEquals([$found_client1, $found_client3], $result);
            }
    }
?>
