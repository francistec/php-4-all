<?
namespace wtf;

use mysqli;
use mysqli_sql_exception;
use get_called_class;

class Model {

    private $connection;
    private $table;

    public function __construct() {
        
    }

    private function connect(){
        $table = get_called_class();
        $table = explode('\\', $table);
        $table = $table[count($table)-1];
        $this->table = strtolower($table);
        $config = include(dirname(__FILE__).'/../config.php');
        $db = $config['db'];
        $this->connection = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
        if(!$this->connection){
            throw new mysqli_sql_exception('Error al conectarse');
        }
    }

    public function __destruct()
    {
        if($this->connection){
            mysqli_close($this->connection);
        }
    }

    public function get($id){
        $this->connect();
        $id= mysqli_escape_string($this->connection, $id);
        $result = $this->connection->query('SELECT * FROM '.$this->table.' where id = '.$id.';');
        $class = get_called_class();
       return  $result->fetch_object($class);
    }
    

    public function getAll(){
        $this->connect();
       $result = $this->connection->query('SELECT * FROM '.$this->table);
       $result = $result->fetch_all(MYSQLI_ASSOC);
       $all = $this->array2Object($result);
       return $all;
    }

    private function array2Object($result){
        $all = [];
        $class = get_called_class();
        for($i=0; $i<count($result);$i++){
            $object = new $class();
            foreach ($result[$i] as $key => $value) {
                $object->$key = $value;
            }
            $all[] = $object;
        }
        return $all;
    }


    public function where($data, $one=false){
        $this->connect();
        $where = "TRUE ";
        foreach($data as $key => $value){
            $key = mysqli_escape_string($this->connection, $key);
            $value = mysqli_escape_string($this->connection, $value);
            $where .= "and {$key} = '{$value}' ";
        }

        $result = $this->connection->query('SELECT * from '.$this->table.' where '.$where);
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $all = $this->array2Object($result);
        if($one){
            return $all[0];
        } else {
            return $all;
        }
        
    }

}