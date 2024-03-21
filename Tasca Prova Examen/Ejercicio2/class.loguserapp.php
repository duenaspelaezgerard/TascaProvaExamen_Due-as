<?php 

        include_once("abstract.databoundobject.php");

        class Logdata extends DataBoundObject {

                protected $IdUserApp;
                protected $IsActive;
                protected $Codi;
                protected $Regtime;
                protected $Comentari;

                protected function DefineTableName() {
                        return("loguserapp");
                }

                protected function DefineRelationMap() {
                        return(array(
                                "iduserapp" => "IdUserApp",
                                "isactive" => "IsActive",
                                "codi" => "Codi",
                                "regtime" => "Regtime",
                                "comentari" => "Comentari"));
                }
        }

?>