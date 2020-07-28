<?php


    function verificarAcceso($url, $modulo){
        session_start();
            if (isset($_SESSION['user_id'])) {
                if($_SESSION["$modulo"] != 1){
                header("Location: $url");
                }      
            }else{
                header("Location: $url");
            }
    }

    
   function verificarAccion($conn, $modulo, $accion){
            $credencial = $conn->query("SELECT * FROM usuario_credencial AS uc, credencial_base AS c, scope AS s WHERE (uc.id_credencialbase_uc = c.id_credencial AND c.id_scope_credencial = s.id_scope) AND (uc.id_usuario_uc =".$_SESSION['user_id']." AND c.$modulo = 1)")->fetchAll(PDO::FETCH_OBJ);
            
            foreach ($credencial as $idCredencial){ 
            
                $records = $conn->prepare("SELECT * FROM usuario_credencial AS uc, credencial_base AS c, usuario AS u, scope AS s WHERE (uc.id_credencialbase_uc = c.id_credencial AND c.id_scope_credencial = s.id_scope AND uc.id_usuario_uc = u.id_usuario) AND (id_usuario_credencial = :id_usuario_credencial AND $modulo = 1)");
                $records->bindParam(':id_usuario_credencial', $idCredencial->id_usuario_credencial);
                $records->execute();
                $results = $records->fetch(PDO::FETCH_ASSOC); 
                if($results["$accion"] == 1){
                    return true;
                }else{
                    return false;
                }
            }
            return false;
    }


    