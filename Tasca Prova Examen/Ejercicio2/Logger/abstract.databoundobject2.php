<?php

abstract class DataBoundObject {

   protected $ID;
   protected $objPDO;
   protected $strTableName;
   protected $arRelationMap;
   protected $blForDeletion;
   protected $blIsLoaded;
   protected $arModifiedRelations;

   protected $logfile;
   protected $logpgsql;
   protected $classNameFile;
   protected $classNamePgsql;

   abstract protected function DefineTableName();
   abstract protected function DefineRelationMap();

   public function __construct(PDO $objPDO, $id=NULL ) {

      $this->strTableName = $this->DefineTableName();
      $this->arRelationMap = $this->DefineRelationMap();
      $this->objPDO = $objPDO;
      $this->blIsLoaded = false;

     
      $this->arModifiedRelations = array();
   }


   public function Load() {     

      if (isset($this->ID)) {
		$strQuery = "SELECT ";

        foreach ($this->arRelationMap as $key => $value) {
			$strQuery .= "\"" . $key . "\",";
        }

        $strQuery = substr($strQuery, 0, strlen($strQuery)-1);
        $strQuery .= " FROM \"" . $this->strTableName . "\" WHERE \"id\" = :eid";

        $objStatement = $this->objPDO->prepare($strQuery);
        $objStatement->bindParam(':eid', $this->ID, PDO::PARAM_INT);
        $objStatement->execute();

        $arRow = $objStatement->fetch(PDO::FETCH_ASSOC);

        foreach($arRow as $key => $value) {

            $strMember = $this->arRelationMap[$key];
            if (property_exists($this, $strMember)) {
                if (is_numeric($value)) {
                   eval('$this->'.$strMember.' = '.$value.';');
                } else {
                   eval('$this->'.$strMember.' = "'.$value.'";');
                };
            };
         };
         $this->blIsLoaded = true;
      };


      
   }

   public function Save() {

      if (isset($this->ID)) {

         $strQuery = 'UPDATE "' . $this->strTableName . '" SET ';

         foreach ($this->arRelationMap as $key => $value) {
            eval('$actualVal = &$this->' . $value . ';');
            if (array_key_exists($value, $this->arModifiedRelations)) {
               $strQuery .= '"' . $key . "\" = :$value, ";
            };
         }

         $strQuery = substr($strQuery, 0, strlen($strQuery)-2);
         $strQuery .= ' WHERE "id" = :eid';
         unset($objStatement);

         $objStatement = $this->objPDO->prepare($strQuery);
         $objStatement->bindValue(':eid', $this->ID, PDO::PARAM_INT);

         foreach ($this->arRelationMap as $key => $value) {
            eval('$actualVal = &$this->' . $value . ';');

            if (array_key_exists($value, $this->arModifiedRelations)) {

               if ((is_int($actualVal)) || ($actualVal == NULL)) {
                  $objStatement->bindValue(':' . $value, $actualVal,PDO::PARAM_INT);
               } else {
                  $objStatement->bindValue(':' . $value, $actualVal,PDO::PARAM_STR);
               };

            };
         };

         $objStatement->execute();

      } else {

         $strValueList = "";
         $strQuery = 'INSERT INTO "' . $this->strTableName . '"(';

         foreach ($this->arRelationMap as $key => $value) {
            eval('$actualVal = &$this->' . $value . ';');
            if (isset($actualVal)) {
               if (array_key_exists($value, $this->arModifiedRelations)) {
                  $strQuery .= '"' . $key . '", ';
                  $strValueList .= ":$value, ";
               };
            };
         }

         $strQuery = substr($strQuery, 0, strlen($strQuery) - 2);
         $strValueList = substr($strValueList, 0, strlen($strValueList) - 2);

         $strQuery .= ") VALUES (";
         $strQuery .= $strValueList;
         $strQuery .= ")";

         unset($objStatement);
         $objStatement = $this->objPDO->prepare($strQuery);

         foreach ($this->arRelationMap as $key => $value) {
            eval('$actualVal = &$this->' . $value . ';');
            if (isset($actualVal)) {   
               if (array_key_exists($value, $this->arModifiedRelations)) {
                  if ((is_int($actualVal)) || ($actualVal == NULL)) {
                     $objStatement->bindValue(':' . $value, $actualVal, PDO::PARAM_INT);
                  } else {
                     $objStatement->bindValue(':' . $value, $actualVal, PDO::PARAM_STR);
                  };
               };
            };
         }

         $objStatement->execute();
         $this->ID = $this->objPDO->lastInsertId($this->strTableName . "_id_seq");

      }
   }

   public function MarkForDeletion() {

      $this->blForDeletion = true;
   }
   
   public function __destruct() {

      if (isset($this->ID)) {   
         if ($this->blForDeletion == true) {

            $strQuery = 'DELETE FROM "' . $this->strTableName . '" WHERE "id" = :eid';
            $objStatement = $this->objPDO->prepare($strQuery);
            $objStatement->bindValue(':eid', $this->ID, PDO::PARAM_INT);   
            $objStatement->execute();
         };
      }

   }

   public function __call($strFunction, $arArguments) {

      $strMethodType = substr($strFunction, 0, 3);
      $strMethodMember = substr($strFunction, 3);

      switch ($strMethodType) {
         case "set":
            return($this->SetAccessor($strMethodMember, $arArguments[0]));
            break;
         case "get":
            return($this->GetAccessor($strMethodMember));   
      };

      date_default_timezone_set('America/New_York');
      $formatterDate = DateTimeImmutable::createFromFormat('U',time());
      $time = $formatterDate->format('Y-m-d H:i:s');

      if (isset($this->ID)) {
         $IdLog = $this->ID;
      } else {
         $IdLog = 0;
      }
      $active = $this->IsActive;
      
      echo '<br> se mete en logfile';
      var_dump($this->logfile);
      $this->logfile->logMessage($idLog,$active,$time,'FUNCION INCORRECTA.', $this->classNameFile::DEBUG);

      echo '<br> se mete en pgsql';
      $this->logpgsql->logMessage($idLog,$active,$time,'FUNCION INCORRECTA.', $this->classNameFile::DEBUG);

         
         
      return(false);   

   }


   private function SetAccessor($strMember, $strNewValue) {
      
      if (property_exists($this, $strMember)) {

         if (is_numeric($strNewValue)) { 
            eval('$this->' . $strMember . ' = ' . $strNewValue . ';');
         } else {
            eval('$this->' . $strMember . ' = "' . $strNewValue . '";');
         };
         $this->arModifiedRelations[$strMember] = "1";
      } else {
         return(false);
      };   
   }

   private function GetAccessor($strMember) {

      if ($this->blIsLoaded != true) {
         $this->Load();
      }
      
      if (property_exists($this, $strMember)) {
         eval('$strRetVal = $this->' . $strMember . ';');
         return($strRetVal);
      } else {
         return(false);
      }; 

   }
   
}

?>