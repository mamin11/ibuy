<?php 
class DB {
    private static $_instance = null;
    private $_pdo, 
            $_query,
            $_error = false,
            $_results,
            $_count = 0 ;

    private function __construct()      {
        try{
            $this->_pdo = new PDO('mysql:host'.config::get('mysql/host').';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
            //echo 'connected';
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){
       if(!isset(self::$_instance)) {
           //if the $_instance is not set, create a new DB instnace
           self ::$_instance = new DB();
       }
       return self::$_instance;
    }

    //query function accepting 2 arguments
    public function query($sql, $params = array()){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            //echo ' db ready for query';
            $x = 1;
           if(count($params)) { 
                foreach($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if($this->_query->execute()){
                // echo ' db query executed ';
                //store the results
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }else{
                // echo' db query not executed';
                //show an error
                $this->_error = true;
            }
        }return $this;
    }

    //the query to be run depends on whatever values are passed into the function.
    public function action($action, $table, $where = array()){
        if(count($where) === 3){
            $operators = array('=', '<', '>', '<=', '>=');
            
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ";
                if(!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }
        }
        return false;
    }

    //this query selects specific column which is passed into the function
    public function actionspecific($action, $column, $table, $where = array()){
        if(count($where) === 3){
            $operators = array('=', '<', '>', '<=', '>=');
            
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)){
                $sql = "{$action} {$column} FROM {$table} WHERE {$field} {$operator} ? ";
                if(!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }
        }
        return false;
    }

    //this returns a specific column from the query run by actionspecific function
    public function get($column, $table, $where){
        return $this->actionspecific('SELECT', $column, $table, $where);
    }
        //this returns all columns from the query run by action function
    public function getAll($table, $where){
        return $this->action('SELECT *', $table, $where);
    }

    //this function accepts and two parameters and deletes data from databse using them.
    public function delete($table, $where){
        return $this->action('DELETE', $table, $where);
    }

    //this function is used to insert data into the database
    public function insert($table, $fields = array()){
        // if(count($fields)){
            $keys = array_keys($fields);
            $values = '';
            $x = 1;

            foreach($fields as $fieldss){
                $values .= '?';
                if($x < count($fields)){
                    $values .= ', ';
                }
                $x++;
            }
             $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})"; // if needed add curly braces around the table variable
            
             if(!$this->query($sql, $fields)->error()){
                return true;
             }
        //}
        return false;
    }

    //this function updates a set of data in the databse
    public function update($table, $col, $id, $fields){
        //we can include a where variable for the where clause instead of just the id clause 
        $set = '';
        $x = 1;

        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE $table SET {$set} WHERE ${col} = {$id}";
        echo  $sql;

        if(!$this->query($sql, $fields)->error()){
            return true;           
         }
        return false;
    }

    //this return results
    public function results(){
        return $this->_results;
    }

    //returns the first item in the results
    public function first(){
        return $this->results()[0];
    }

    //this returns the errors
    public function error(){
        return $this->_error;
    }

    public function count(){
        return $this->_count;
    }

}