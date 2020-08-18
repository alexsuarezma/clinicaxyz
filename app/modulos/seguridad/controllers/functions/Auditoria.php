<?php
date_default_timezone_set('America/Guayaquil');

    class Auditoria {

        public function __construct($accion,$modulo,$descripcion,$usuario,$credencial){

            $this->accion = $accion;
            $this->modulo = $modulo;
            $this->descripcion = $descripcion;
            $this->usuario = $usuario;
            $this->credencial = $credencial;
        }

        public function Registro($conn){

            try {
                $created = date("Y-m-d H:i:s");

                $sql = "INSERT INTO auditoria (accion,modulo,descripcion,usuario,credencial,created_at) VALUES (:accion,:modulo,:descripcion,:usuario,:credencial,:created_at)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':accion', $this->accion);
                $stmt->bindParam(':modulo', $this->modulo);
                $stmt->bindParam(':descripcion', $this->descripcion);
                $stmt->bindParam(':usuario', $this->usuario);
                $stmt->bindParam(':credencial', $this->credencial);
                $stmt->bindParam(':created_at', $created);
                $stmt->execute();
            } catch (\Throwable $th) {
                //$this->error=$error->getMessage();
                return false;
            }
            return true;
        }
    }