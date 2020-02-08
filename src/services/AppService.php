<?php
abstract class AppService
{
    public $dbcon = "";
    public $id = "";
    public $body = NULL;
    public $default_db_conf = array(
        "host" => "",
        "user" => "",
        "pass" => "",
        "db" => ""
    );
    public $db_conf = NULL;

    function __construct($dbconfig, $request){
        $this->initDatabase($dbconfig);
        $this->parseRequest($request);
        $this->request = $request;
        //$this->valSvc = new ValidationService();
    }

    protected function initDatabase($conf){
        if ($conf==NULL)
            $this->db_conf = $this->default_db_conf;
        else
            $this->db_conf = $conf;

        $dbhost=$this->db_conf["host"];
        $dbuser=$this->db_conf["user"];
        $dbpass=$this->db_conf["pass"];
        $dbname=$this->db_conf["db"];
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $this->dbcon = $dbh;
    }

     function sanitize($field) {
        $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
        return $field;
    }

    function required($field, $name) {
        if(!empty($field)){
            return FALSE;
        }
        else {
            return "Error: ". $name . " is required";
        }
    }

    function validateEmail($field) {
        if(filter_var($field, FILTER_VALIDATE_EMAIL)){
            return FALSE;
        }
        else {
            return "Error: must enter valid email";
        }
    }

    function validatePhone($field) {
        if (filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{10}$/")))){
            return FALSE;
        }
        else {
            return "Error: phone number must be 10 digits";
        }
    }

    protected function parseRequest($request)
    {
        $this->body = json_decode($request->getBody());
        $this->id = $request->getAttribute('id');
    }
    abstract public function create();
    abstract public function update();
    abstract public function delete();
    abstract public function read();
    abstract public function list();

}
?>
