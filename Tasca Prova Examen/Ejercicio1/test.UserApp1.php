<?php
        require("abstract.databoundobject.php");
        require("class.pdofactory.php");
        require("class.userApp.php");


        $strDSN = "pgsql:dbname=usuaris;host=localhost;port=5432";
        $objPDO = PDOFactory::GetPDO($strDSN, "postgres", "postgres", 
            array());
        $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // $objUser = new UserApp($objPDO);

        // $objUser->setNom("Juan Pérez");
        // $objUser->setGroup("Administradores");
        // $objUser->setCreated("2023-07-15 09:30:00");
        // $objUser->setLastUpdate("2024-03-20 14:45:00");        
        // $objUser->setIsActive(true);
        // print "</br>Guardando...<br />";
        // $objUser->Save();

        
        // $id = $objUser->getID();
        // print "ID es " . $id . "<br />";
        // print "Nombre es " . $objUser->getNom() . "<br />";
        // print "Grupo es " . $objUser->getGroup() . "<br />";
        // print "Creado el " . $objUser->getCreated() . "<br />";
        // print "Actualizado is " . $objUser->getLastUpdate() . "<br />";
        // print "Activo:  " . $objUser->getIsActive() . "<br />";


        // $objUser2 = new UserApp($objPDO);

        // $objUser2->setNom("María González");
        // $objUser2->setGroup("Desarrolladores");
        // $objUser2->setCreated("2019-08-05 16:40:00");
        // $objUser2->setLastUpdate("2020-11-18 09:12:30");        
        // $objUser2->setIsActive(true);
        // print "</br>Guardando...<br />";
        // $objUser2->Save();


        // $id = $objUser2->getID();
        // print "ID es " . $id . "<br />";
        // print "Nombre es " . $objUser2->getNom() . "<br />";
        // print "Grupo es " . $objUser2->getGroup() . "<br />";
        // print "Creado el " . $objUser2->getCreated() . "<br />";
        // print "Actualizado is " . $objUser2->getLastUpdate() . "<br />";
        // print "Activo:  " . $objUser2->getIsActive() . "<br />";

        $objUser3 = new UserApp($objPDO,7);

        // $objUser3->setNom("Luisa Martínez");
        // $objUser3->setGroup("Analistas");
        // $objUser3->setCreated("2017-05-20 10:20:00");
        // $objUser3->setLastUpdate("2023-09-08 14:55:20");        
        // $objUser3->setIsActive(true);
        // print "</br>Guardando...<br />";
        // $objUser3->Save();


        // $id = $objUser3->getID();
        // print "ID es " . $id . "<br />";
        // print "Nombre es " . $objUser3->getNom() . "<br />";
        // print "Grupo es " . $objUser3->getGroup() . "<br />";
        // print "Creado el " . $objUser3->getCreated() . "<br />";
        // print "Actualizado is " . $objUser3->getLastUpdate() . "<br />";
        // print "Activo:  " . $objUser3->getIsActive() . "<br />";
  
        // print "<br/>Actualizando datos de Luisa</br></br>";

        // $objUser3->setNom("Elena Ramírez");
        // $objUser3->setGroup("Ventas");
        // $objUser3->setCreated("2022-10-12 08:45:00");
        // $objUser3->setLastUpdate("2023-12-29 17:20:30");
        // $objUser3->setIsActive(0);
        
        // $id = $objUser3->getID();
        // print "ID es " . $id . "<br />";
        // print "Nombre es " . $objUser3->getNom() . "<br />";
        // print "Grupo es " . $objUser3->getGroup() . "<br />";
        // print "Creado el " . $objUser3->getCreated() . "<br />";
        // print "Actualizado is " . $objUser3->getLastUpdate() . "<br />";
        // print "Activo:  " . $objUser3->getIsActive() . "<br />";

        // print "</br>Guardando...<br />";
        // $objUser3->Save();

        print "Voy a destruir a Elena...<br />";
        $objUser3->MarkForDeletion();
        unset($objUser3);
?>