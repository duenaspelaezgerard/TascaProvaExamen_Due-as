<?php 

        include_once("abstract.databoundobject2.php");

        class LogUserApp extends DataBoundObject {

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