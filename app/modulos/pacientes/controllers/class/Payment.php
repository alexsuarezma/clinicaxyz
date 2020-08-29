<?php
require_once("../bin/conekta-php-master/lib/Conekta.php");

class Payment{
    private $ApiKey = "key_tr9Ky52r5D6AqZhaTWz9XQ";
    private $ApiVersion = "2.0.0";
    public function __construct($token,$card,$name,$descripcion,$total,$email){
        $this->token=$token;
        $this->card=$card;
        $this->name=$name;
        $this->descripcion=$descripcion;
        $this->total=$total;
        $this->email=$email;
    }

    public function Pay(){
        \Conekta\Conekta::setApiKey($this->ApiKey);
        \Conekta\Conekta::setApiVersion($this->ApiVersion);
        
        if(!$this->Validate())
            return false;
    
        if(!$this->CreateCustomer())
            return false;

        if(!$this->CreateOrder())
            return false;
        
        if(!$this->Save())
            return false;
        
        return true;

    }
    
    public function Save(){
        require_once('../../../../database.php');
        error_reporting(E_ALL ^ E_NOTICE);
        date_default_timezone_set('AMERICA/GUAYAQUIL');
        
            $card = substr($this->card,-4, 4);
            $card = '************'.$card;
            $id_paciente_re=$_POST['id_pa'];
            $especialista=$_POST['id_doc'];
            $hora=$_POST['hora'];
            $fecha=$_POST['fecha'];
            $especialidad=$_POST['especialidad'];
            

            $fecha_de_registro=Date("Y-m-d H-i-s");

            $conteo = $conn->query("SELECT * FROM citas WHERE fecha='$fecha'")->rowCount();

            if ($conteo < 13 ) {
                            
                $total = $conn->query("SELECT * from citas_medica where fecha='$fecha' and id_hora='$hora' and id_empleados= '$especialista'")->rowCount();

                if ($total<1) {

                    $sql = "INSERT INTO citas (fecha,id_hora,paciente,estado,tratamiento,observaciones,medicamentos) 
                    VALUES (:fecha,:id_hora,:paciente,:estado,:tratamiento,:observaciones,:medicamentos)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':fecha', $fecha);
                    $stmt->bindParam(':id_hora', $hora);    
                    $stmt->bindParam(':paciente', $id_paciente_re); 
                    $stmt->bindValue(':estado', 'Pendiente', PDO::PARAM_STR);
                    $stmt->bindValue(':tratamiento', null, PDO::PARAM_INT);
                    $stmt->bindValue(':observaciones', null, PDO::PARAM_INT);
                    $stmt->bindValue(':medicamentos', null, PDO::PARAM_INT);
                    $stmt->execute();
                    $id = $conn->lastInsertId();


                    $doctor = $conn->query("SELECT * from empleados_medico where id_empleados_medico= '$especialista'")->fetchAll(PDO::FETCH_OBJ);
                    $id_doc=$doctor[0]->id_medico;


                    $sql = "INSERT INTO citas_medicos (cita,medico) VALUES (:cita,:medico)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':cita', $id);
                    $stmt->bindParam(':medico', $id_doc);    
                    $stmt->execute();


                    $sql = "INSERT INTO cita_especialidad (cita,especialidad) VALUES (:cita,:especialidad)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':cita', $id);
                    $stmt->bindParam(':especialidad', $especialidad);    
                    $stmt->execute();
                    
                    //FACTURACIÓN
                    $sql = "INSERT INTO pagos (id_cita,id_tarjeta,iva,sub_total,numero_tarjeta,id_order) 
                    VALUES (:id_cita,:id_tarjeta,:iva,:sub_total,:numero_tarjeta,:id_order)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id_cita', $id);
                    $stmt->bindValue(':id_tarjeta', null, PDO::PARAM_INT);  
                    $stmt->bindValue(':iva', 1.8, PDO::PARAM_INT);  
                    $stmt->bindValue(':sub_total', 13.2, PDO::PARAM_INT);  
                    $stmt->bindParam(':numero_tarjeta', $card);
                    $stmt->bindParam(':id_order', $this->order->id);
                    $stmt->execute();
                    
                    $this->idLast = $id;
                    return true;
                }else{
                    $this->error = 'La hora escogida ya esta ocupada!!';
                    return false;
                }
            } else {
                    $this->error = 'Ya no hay cupos para el dia escogido...';
                    return false;
            }
    }

    public function CreateOrder(){
        try{
            $this->order = \Conekta\Order::create(
                array(
                    "amount"=>$this->total,
                    "line_items"=> array(
                        array(
                            "name"=>$this->descripcion,
                            "unit_price"=>$this->total*100,
                            "quantity"=>1
                        )
                    ),
                    "currency"=>"MXN",
                    "customer_info"=>array(
                        "customer_id"=>$this->customer->id
                    ),
                    "changes"=>array(
                        array(
                            "payment_method"=>array(
                                "type"=>"default"
                            )
                        )
                    )
                )
            );
        } catch (\Conekta\ProccessingError $error) {
            $this->error=$error->getMessage();
            return false;
        } catch (\Conekta\ParameterValidationError $error) {
            $this->error=$error->getMessage();
            return false;
        } catch (\Conekta\Handler $error) {
            $this->error=$error->getMessage();
            return false;
        } 

        return true;
    }

    public function CreateCustomer(){
        try {
            $this->customer = \Conekta\Customer::create(
                array(
                    "name"=> $this->name,
                    "email"=> $this->email,
                    "payment_sources"=> array(
                        array(
                            "type" => "card",
                            "token_id" => $this->token
                        )
                    )
                )
            );
        } catch (\Conekta\ProccessingError $error) {
            $this->error=$error->getMessage();
            return false;
        } catch (\Conekta\ParameterValidationError $error) {
            $this->error=$error->getMessage();
            return false;
        } catch (\Conekta\Handler $error) {
            $this->error=$error->getMessage();
            return false;
        } 
        return true;
    }

    public function Validate(){
        if($this->card=="" || $this->name=="" || $this->descripcion=="" || $this->total=="" || $this->email==""){
            $this->error="El número de tarjeta, el nombre, concepto, monto y correo son obligatorios";
            return false;
        }

        if (strlen($this->card)<=14) {
            $this->error="El número de tarjeta debe tener al menos 15 caracteres";
            return false;
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->error="El correo electrónico no tiene un formato de correo valido";
            return false;
        }

        if($this->total<=1){
            $this->error="El monto debe ser mayor a $1 dolar";
            return false;
        }

        return true;
    }
}
