<?php
class ffDB
{
    public $user;
    public $pass;
    public $db;
    public $sqlQuery;
    public $table;
    protected $bdc;

    function connect()
    {
        try {
            $this->dbc = new PDO('mysql:host=localhost;dbname=' . $this->db, $this->user, $this->pass);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function runFetch()
    {
        $sth = $this->dbc->prepare($this->sqlQuery);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_BOTH);
    }

    public function doMany($cols, $values)
    {
        $table = str_ireplace('.csv', '', $this->table);
        $columns = implode("`,`", $cols);
        $values = implode(", :", $cols);

        $stmt = $this->dbc->prepare("INSERT INTO $table ($columns) VALUES (:$values)");

        $n = 0;
        foreach ($cols as $key) {
            $stmt->bindParam(':' . $key, $values[$n]);
            $n++;
        }

        $stmt->execute();
    }

    public function runRequest()
    {
        return $this->dbc->exec($this->sqlQuery);
    }

    /*
    $tst = new ffDB();
    $tst->user = 'admin';
    $tst->pass = '******';
    $tst->db = 'db_tst';
    $tst->connect();
    $tst->sqlQuery = '';
    */
}
?>
