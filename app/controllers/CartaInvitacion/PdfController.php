<?php
//--Controlador para generar carta invitacion
class CartaInvitacion_PdfController extends BaseController {

public function get_pdf()
    {
      //creamos array de todas las claves enviadas para generar carta invitacióm
       $clave = Input::all();
    //print_r($clave);
        //limpiamos y ordenamos el array
        $token      = $clave['_token'];
        $fecha      = $clave['date1'];
        $ejecutor   = $clave['ejecutores'];
        $boton      = $clave['boton'];
        $mun_actual = $clave['mun'];

        unset($clave['mun']);
        unset($clave['ejecutores']);
        unset($clave['boton']);
        unset($clave['_token']);
        unset($clave['date1']);
            //BUCLE PARA GUARDAR LOS DATOS A LA BASE DE DATOS
       $ejecutor=($claves2['captura']['ejecutores']=$ejecutor);
       $nombre_eje= personas::where('id_p', $ejecutor)->pluck('nombrec');

       foreach($clave as $cla => $value)
        {

          $cv    =($claves2['captura']['clave']=$value);
          $cv    = str_replace('(', '',$cv);
          $vale[]    = explode(',',$cv);

          $fecha =($claves2['captura']['fecha']=$fecha);

foreach ($vale as $clave ) {
            $claves=$clave[0];

        //insert a la tabla ejecucion_fiscal
           $ejecucion = new ejecucion;
           $ejecucion->clave =$claves;
           $ejecucion->cve_status ='CI';
           //$ejecucion->f_inicio_ejecucion=$fecha;
           $ejecucion->save();

        //select a la tabla ejecucion fiscal
           $id_ejecucion = $ejecucion->id_ejecucion_fiscal;
           //array de nuevos id_ejecucion para insertar a la tabla requerimientos
           $data[]= $id_ejecucion;

        //insert a la tabla requerimientos
        $requerimiento                      = new requerimientos;
        $requerimiento->id_ejecucion_fiscal =$id_ejecucion;
        $requerimiento->cve_status          ='CI';
        $requerimiento->save();
 }
    }


   //ENVIO A LA VISTA DEL PDF CARTA INVITACION
//print_r($data);
   $vista = View::make('CartaInvitacion.cartainvitacion', compact('data', 'fecha', 'nombre_eje', 'mun_actual','vale'));
   //CARGA DEL PDF CARTA INVITACION SOLO GENERA UNA TODAVIA NO RESUELVO COMO GENERAR UNA PAGINA POR CLAVE
   $pdf = PDF::load($vista)->show();
   $response = Response::make($pdf, 200);
   $response->header('Content-Type', 'application/pdf');
   return $response;
  }
}
