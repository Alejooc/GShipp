<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter Shippment Controller
 *
 * @link            https://github.com/
 *
 * @version         1.0.0
 */
class Shippment
{
    public function __construct()
    {
    $this->name = 'alejo'; // demo value xd
    }

    public function main($params)
    {   
        $obj = (object) $params;

        if ($obj->server== 'env') {
            $envia = $this->envia_get($obj);
            return $envia;
        }elseif($obj->server== 'serv'){
            $servientrega = $this->servientrega_get($obj);

             //ejemplo calcular fecha estimada de entrega
            $aproxDate = $this->aproxDate();

            foreach ($servientrega->Results[0]->movimientos as $value) {
                // idProceso  en distri = 9 
                if ($value->IdProceso == "9") {
                    $aproxDate = $value->fecha;
                    break;
                }
            }
            $servientrega->Results[0]->aproxDate = $aproxDate; 
            return $servientrega;  
        }   
    }
    public function aproxDate(){
        $fecha = date_create("29-10-2021");
        date_add($fecha,date_interval_create_from_date_string("9 days"));
        $estimada = date_format($fecha,'d/m/y');
        return $estimada;
    }
    public function envia_get($params){
        $url="https://portal.envia.co/ServicioRestConsultaEstados/Service1Consulta.svc/ConsultaEstadoGuia/$params->guia";
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_NOBODY, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            $data = curl_exec($ch); 
            $err = curl_error($ch);
            curl_close($ch); 
            print_r($err);
            return json_decode($data);
        } catch (\error $th) {
            //echo $th;
        }
        
    }
    public function servientrega_get($params){
        $url="https://mobile.servientrega.com/Services/ShipmentTracking/api/ControlRastreovalidaciones";
        try {
            $fields = [
                'datorespuestaUsuario'=> "0",
                'idValidacionUsuario'=> "0",
                'idpais'=> 1, //1 = colombia 
                'lenguaje'=> "es",
                'numeroGuia'=> $params->guia,
                'tipoDatoValidar'=> "0"];
            $fields_string = http_build_query($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            $data = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            print_r($err);
            return json_decode($data);
        } catch (\error $th) {
            //echo $th;
        }
        
    }

}
