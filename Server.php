<?php

require("./Conn.php");

if (!isset($_POST['req'])) {
    die("No request provided.");
} else {
    if (filter_input(INPUT_POST, 'req') == "prueba") {
        $json = array("success" => false, "prueba" => null);
        $json['success'] = true;
        $json['prueba'] = '=)';
        print(json_encode($json));
    }

    //Select de los carros
    if (filter_input(INPUT_POST, 'req') == "getRegisters") {

        $result = $conn->query("select register.name, register.lastName, register.ID, register.email, register.uniqueId from register  limit 100;");
        $info = $result->fetch_row();
        $registers = array($info);
        while ($info = $result->fetch_row()) {
            array_push($registers, $info);
        }
        $json = array("success" => false, "registers" => null);
        $json['success'] = true;
        $json['registers'] = $registers;
        print(json_encode($json));
    }

    //Insert register
    if (filter_input(INPUT_POST, 'req') == "insertRegister") {


        $auxName = filter_input(INPUT_POST, 'name');
        $auxLastName = filter_input(INPUT_POST, 'lastName');
        $auxID = filter_input(INPUT_POST, 'ID');
        $auxEmail = filter_input(INPUT_POST, 'email');
        $auxUnique = sha1($auxID . '' . $auxEmail);

        $sql = "INSERT INTO register (name,lastName, ID, email, uniqueId) values ('" . $auxName . "','" . $auxLastName . "','" . $auxID . "','" . $auxEmail . "','" . $auxUnique . "');";

        $json = array("success" => false, 'query' => '', 'image'=>'');
        if ($conn->query($sql) === TRUE) {
            require_once 'MailerTest/QrTest.php';
            QrGenerate($auxUnique);
            require 'MailerTest/test.php';
            sendEmail($auxEmail, $auxName, $auxUnique);

            $json['success'] = true;
            $json['query'] = $sql;
            $json['image'] = '../images/' . $auxUnique . 'image.png';
        } else if ($conn->query($sql) === FALSE) {
            $json['success'] = false;
            $json['query'] = $sql;
        }
        print(json_encode($json));
    }

  
  
}

