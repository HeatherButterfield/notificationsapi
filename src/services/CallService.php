<?php
require_once 'AppService.php';
class CallService extends AppService
{
    function __construct($dbconfig, $request){
        parent::__construct($dbconfig, $request);
    }

    function list() {
        $sql = "select * FROM coaches";
        try {
            $stmt = $this->dbcon->query($sql);
            $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            return json_encode($wines);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function read() {
        $id = $request->getAttribute('id');
        $sql = "SELECT * FROM coaches WHERE id=$id";
        try {
            $stmt = $this->dbcon->query($sql);
            $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            return json_encode($wines);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function create() {
        $team = json_decode($this->request->getBody());

        $sql = "INSERT INTO coaches (id, name, team, phone, email) VALUES (:id, :name, :team, :phone, :email)";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $team->id);
            $team->id = $this->sanitize($team->id);
            $stmt->bindParam("name", $team->name);
            $team->name = $this->sanitize($team->name);
            $nameError = $this->required($team->name, "name");
            $stmt->bindParam("team", $team->team);
            $team->team = $this->sanitize($team->team);
            $stmt->bindParam("phone", $team->phone);
            $team->phone = $this->sanitize($team->phone);
            $phoneError = $this->required($team->phone, "phone");
            $phoneError = $this->validatePhone($team->phone);
            $stmt->bindParam("email", $team->email);
            $team->email = $this->sanitize($team->email);
            $emailError = $this->required($team->email, "email");
            $emailError = $this->validateEmail($team->email);
            if (!$emailError && !$nameError) {
                $stmt->execute();
                $db = null;
                echo json_encode($team);
            }
            if ($emailError) {
                echo $emailError;
            }
            if ($nameError) {
                echo $nameError;
            }
            if ($phoneError) {
                echo $phoneError;
            }
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function update() {
        $team = json_decode($this->request->getBody());
        $id = $request->getAttribute('id');
        $sql = "UPDATE coaches SET name=:name, team=:team, phone=:phone, email=:email WHERE id=:id";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->bindParam("name", $team->name);
            $team->name = $this->sanitize($team->name);
            $stmt->bindParam("team", $team->team);
            $team->team = $this->sanitize($team->team);
            $stmt->bindParam("phone", $team->phone);
            $team->phone = $this->sanitize($team->phone);
            $stmt->bindParam("email", $team->email);
            $emailError = $this->validateEmail($team->email);
            if (!$emailError) {
                $stmt->execute();
                $db = null;
                echo json_encode($team);
            }
            if ($emailError) {
                echo $emailError;
            }
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function delete() {
        $id = $this->request->getAttribute('id');
        $sql = "DELETE FROM coaches WHERE id=:id";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $db = null;
            echo '{"error":{"text":"successfully! deleted Team"}}';
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
}
