<?php
class DatabaseStatement extends PDOStatement
{
    public $dbh;

    protected function __construct($dbh) {
        $this->dbh = $dbh;
    }

    protected function sqlstring($sql,$placeholders)
    {
        foreach($placeholders as $k => $v){
            //$sql = preg_replace('/:'.$k.'/',"'".$v."'",$sql);
            $sql = preg_replace('/'.$k.'/',"'".$v."'",$sql);
        }
        return $sql;
    }

    public function execute ($params = array()) {
        $q = $this->sqlstring($this->queryString,$params);

        // Fetch a logger, it will inherit settings from the root logger
        $log = Logger::getLogger('myLogger');
        $log->debug($q);

        try {
            $result = parent::execute($params);
        } catch (PDOException $e) {
            $log->fatal('E_PDO: ' . $e->getMessage());
            header('location: ' . URL . 'erreur/interne');
            exit();
        }
        return $result;
    }
}
