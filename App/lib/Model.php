<?php

namespace App\lib;
use App\lib\Config;

/**
 * Description of Model
 *
 * @author Alisson Ferreira CPF 128-157-876.28
 * Classe responsavel para fazer consulta,insert e update no banco de dados
 */

class Model extends Config{

    protected $con;

    public function __construct() {
        try{
            $this->con = new \PDO("mysql:host=".self::Myhost.";charset=utf8;dbname=".self::Mydbname, self::Myuser, self::Mypass);
            $this->con->exec("set names ".self::charset);
            $this->con->exec("SET character_set_connection=utf8");
            $this->con->exec("SET character_set_client=utf8");
            $this->con->exec("SET character_set_results=utf8");
            $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $ex){
            die($ex->getMessage());
        }
    }

    public function Select($table){
        $sql = "select * from {$table}";
        try{
            $state = $this->con->prepare($sql);
            $state->execute();
        } catch (\PDOException $ex){
            die($ex->getMessage(). "  ".$sql);
        }

        $array = array();
        while ($row = $state->fetchObject()){
            $array[] = $row;
        }
        return $array;
    }

    public function SelectLeft($sql){
        try{
            $state = $this->con->prepare($sql);
            $state->execute();
        } catch (\PDOException $ex){
            die($ex->getMessage(). "  ".$sql);
        }

        $array = array();
        while ($row = $state->fetchObject()){
            $array[] = $row;
        }

        return $array;
    }

    public function Insert($dados,$table){
        $sql =  "INSERT INTO {$table}";
        $sql .= " (`" . implode("`, `", array_keys($dados)) . "`)";
        $sql .= " VALUES ('" . implode("', '", $dados) . "') ";
        $result = true;
        try{

            $state = $this->con->prepare($sql);
            $state->execute(array('widgets'));


        } catch (\PDOException $ex){
            $errro = $ex->getCode();
            $result = false;
        }
        return array('sucess' =>$result, 'erro'=>$errro, 'codigo' => $this->con->lastInsertId($table),'sql'=>$sql);

    }

    public function Update($inf ,$tabela , $onde , $id){
        try {
            foreach($inf as $key => $value){
                $dados[] = $key."='".$value."'";
            }

            $sql = "UPDATE {$tabela} SET ".implode(', ', $dados)." WHERE {$onde} = ".$id;
            $state = $this->con->prepare($sql);
            $state->execute(array('widgets'));

        } catch (\PDOException $ex) {
            die($ex->getMessage().' -- '.$sql);
        }

        return array('sucess' =>true, 'feedbac'=>'', 'sql' =>$sql);

    }

    public function Delete($tabela,$onde,$id){
        try{
            $sql = "delete from {$tabela} where {$onde} = {$id}";
            $state = $this->con->prepare($sql);
            $state->execute();
        } catch (\PDOException $ex){
            die($ex->getCode());
        }

        return array('sucess' =>true, 'feedbac'=>'', 'sql' =>$sql);
    }

    public function DeleteFrom($tabela){
        try{
            $sql = "delete from {$tabela}";
            $state = $this->con->prepare($sql);
            $state->execute();
        } catch (\PDOException $ex){
            die($ex->getMessage().'----'.$sql);
        }

        return array('sucess' =>true, 'feedbac'=>'', 'sql' =>$sql);
    }

    public function Query($sql){
        try{
            $state = $this->con->prepare($sql);
            $state->execute();
        } catch (\PDOException $ex){
            die($ex->getMessage());
        }

        return array('sucess' =>true, 'feedbac'=>'', 'sql' =>$sql);
    }

    public function selectWhere($table,$onde,$id){
        $sql = "select * from {$table} where {$onde} = {$id}";
        try{
            $state = $this->con->prepare($sql);
            $state->execute();
        } catch (\PDOException $ex){
            die($ex->getMessage(). "  ".$sql);
        }

        $array = array();
        while ($row = $state->fetchObject()){
            $array[] = $row;
        }

        return $array;
    }

    public function Linha($table,$onde,$id){
        $sql = "select * from {$table} where {$onde} = {$id}";
        try{
            $state = $this->con->prepare($sql);
            $state->execute();
            $linha = $state->fetchObject();
        } catch (\PDOException $ex){
            die($ex->getMessage(). "  ".$sql);
        }
        return $linha;
    }

    public function linhaLeft($sql){
        try{
            $state = $this->con->prepare($sql);
            $state->execute();
            $linha = $state->fetchObject();
        } catch (\PDOException $ex){
            die($ex->getMessage(). "  ".$sql);
        }
        return $linha;
    }

}
