<?php 

        include_once("abstract.databoundobject.php");

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
                                "idUserApp" => "IdUserApp",                             
                                "codi" => "Codi",
                                "comentari" => "Comentari",
                                "regTime" => "Regtime",
                                "isActive" => "IsActive"));
                }
        }

?>