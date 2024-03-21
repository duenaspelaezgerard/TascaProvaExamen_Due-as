<?php

class UserApp extends DataBoundObject {

        protected $Nom;
        protected $Group;
        protected $Created;

        protected $LastUpdate;
        protected $IsActive;


        protected function DefineTableName() {
                return("userapp");
        }

        protected function DefineRelationMap() {
                return(array(
                        "id" => "ID",
                        "nom" => "Nom",
                        "group" => "Group",
                        "created" => "Created",
                        "lastUpdate" => "LastUpdate",
                        "isActive" => "IsActive"
                ));
        }
}

?>