<?php

    namespace proyecto;

    use PDO;

    class Conexion
    {
        /**
         * Conexion constructor.
         */
        public static $DB = null;
        public $dbname = "";
        public $host = "";
        public $user = "";
        public $password = "";
        /**ic
         * Conexion constructor.
         * @param string $dbname
         * @param string $host
         * @param string $user
         * @param string $password
         */
        public function __construct(string $dbname, string $host, string $user, string $password)
        {
            $this->dbname = $dbname;
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
        }
        /**
         * @return mixed
         */
        public function getDB()
        {
            return $this->DB;
        }
        /**
         * @param mixed $DB
         */
        public function setDB($DB): void
        {
            $this->DB = $DB;
        }
        /**
         * @return string
         */
        public function getDbname(): string
        {
            return $this->dbname;
        }
        /**
         * @param string $dbname
         */
        public function setDbname(string $dbname): void
        {
            $this->dbname = $dbname;
        }
        /**
         * @return string
         */
        public function getHost(): string
        {
            return $this->host;
        }
        /**
         * @param string $host
         */
        public function setHost(string $host): void
        {
            $this->host = $host;
        }
        /**
         * @return string
         */
        public function getUser(): string
        {
            return $this->user;
        }
        /*
        return         * @param string $user
         */
        public function setUser(string $user): void
        {
            $this->user = $user;
        }
        /**
         * @return string
         */
        public function getPassword(): string
        {
            return $this->password;
        }
        /**
         * @param string $password
         */
        public function setPassword(string $password): void
        {
            $this->password = $password;
        }
        public function getPDO():PDO
        {
            try {
                $dsn = "mysql:host=localhost;dbname=$this->dbname";
                if (self::$DB == null) {
                    self::$DB = new PDO($dsn, $this->user, $this->password);
                }
                return   self::$DB;
            } catch (Exception $e) {

                return $e;
            }
        }
        public function closeConexion(): void
        {
            self::$DB = null;
        }
    }
