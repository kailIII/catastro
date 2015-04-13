<?php

use \PMap;

class ConsultaAlfaController extends \BaseController {
	public function store(){
	   
        $PM_MAP_FILE = "/var/www/html/Tabasco.map";
        $map = ms_newMapObj($PM_MAP_FILE);
        $scaleLayers = 1;       

        if($_REQUEST["query"] == "Clave"){
            
            $mapW = $_REQUEST["mapW"];
            $mapH = $_REQUEST["mapH"];
            $municipio = $_REQUEST["variables"][0];
            $clave_catas = $_REQUEST["variables"][1];
           
    		$dbconn = pg_connect("host=127.0.0.1 dbname=catastro user=postgres") or die('No se ha podido conectar: ' . pg_last_error());
   			$sql="select st_xmin(p.geom)-5, st_ymin(p.geom)-5, st_xmax(p.geom)+5, st_ymax(p.geom)+5  from predios p where p.municipio = '$municipio' and p.clave_catas = '$clave_catas'";
    		
    		$result = pg_query($sql) or die('La consulta fallo: ' . pg_last_error());

    		if ($result && pg_num_rows($result) != 0){
    		    $row = pg_fetch_row($result); 
                $_REQUEST["extent"] = $row[0]."+".$row[1]."+".$row[2]."+".$row[3] ;                                                
                

        $pmap = new PMAP($map);
        $pmap->pmap_create();

        $mapURL      = $pmap->pmap_returnMapImgURL();
        $scalebarURL = $pmap->pmap_returnScalebarImgURL();
        $mapJS       = $pmap->pmap_returnMapJSParams();
        $mapwidth    = $pmap->pmap_returnMapW();
        $mapheight   = $pmap->pmap_returnMapH();
        $geo_scale   = $pmap->pmap_returnGeoScale();
        
        
        
        // JS objects from map creation
        $strJS  = '"mapW":"' . $mapJS['mapW'] . '", ';
        $strJS .= '"mapH":"' . $mapJS['mapH'] . '", ';
        $strJS .= '"refW":"' . $mapJS['refW'] . '", ';
        $strJS .= '"refW":"' . $mapJS['refW'] . '", ';
        $strJS .= '"extent":"' . $_REQUEST["extent"] . '", ';
        $strJS .= '"minx_geo":"' . $mapJS['minx_geo'] . '", ';
        $strJS .= '"miny_geo":"' . $mapJS['miny_geo'] . '", ';
        $strJS .= '"maxx_geo":"' . $mapJS['maxx_geo'] . '", ';
        $strJS .= '"maxy_geo":"' . $mapJS['maxy_geo'] . '", ';
        $strJS .= '"xdelta_geo":"' . $mapJS['xdelta_geo'] . '", ';
        $strJS .= '"ydelta_geo":"' . $mapJS['ydelta_geo'] . '", ';
        $strJS .= '"refBoxStr":"' . $mapJS['refBoxStr'] . '" ';
        
        
        // Serialize url_points
        $urlPntStr = '';
        
        // return JS object literals "{}" for XMLHTTP request 
        echo "{\"sessionerror\":\"false\",  \"mapURL\":\"$mapURL\", \"scalebarURL\":\"$scalebarURL\", \"geo_scale\":\"$geo_scale\",".$strJS."}";

            }else{
                $strJS  = '"msgError":"No se ha encontrado la Clave Catastral Solicitada: ['.$clave_catas.'] en el municipio indicado "';

                echo "{\"sessionerror\":\"QueryError\",".$strJS."}";
            }
            
                                    
    		
            
        }else{
        // CREATE NEW MAP
        $pmap = new PMAP($map);
        $pmap->pmap_create();
        
        $mapURL      = $pmap->pmap_returnMapImgURL();
        $scalebarURL = $pmap->pmap_returnScalebarImgURL();
        $mapJS       = $pmap->pmap_returnMapJSParams();
        $mapwidth    = $pmap->pmap_returnMapW();
        $mapheight   = $pmap->pmap_returnMapH();
        $geo_scale   = $pmap->pmap_returnGeoScale();
        
        
        
        // JS objects from map creation
        $strJS  = '"mapW":"' . $mapJS['mapW'] . '", ';
        $strJS .= '"mapH":"' . $mapJS['mapH'] . '", ';
        $strJS .= '"refW":"' . $mapJS['refW'] . '", ';
        $strJS .= '"refH":"' . $mapJS['refH'] . '", ';
        $strJS .= '"minx_geo":"' . $mapJS['minx_geo'] . '", ';
        $strJS .= '"miny_geo":"' . $mapJS['miny_geo'] . '", ';
        $strJS .= '"maxx_geo":"' . $mapJS['maxx_geo'] . '", ';
        $strJS .= '"maxy_geo":"' . $mapJS['maxy_geo'] . '", ';
        $strJS .= '"xdelta_geo":"' . $mapJS['xdelta_geo'] . '", ';
        $strJS .= '"ydelta_geo":"' . $mapJS['ydelta_geo'] . '", ';
        $strJS .= '"refBoxStr":"' . $mapJS['refBoxStr'] . '" ';
        
        
        // Serialize url_points
        $urlPntStr = '';
        
        // return JS object literals "{}" for XMLHTTP request 
        echo "{\"sessionerror\":\"false\",  \"mapURL\":\"$mapURL\", \"scalebarURL\":\"$scalebarURL\", \"geo_scale\":\"$geo_scale\",".$strJS."}";
}	}  
    
    protected function img2map($width,$height,$point,$ext) {
    		
    	$minx = $ext->minx;
    	$miny = $ext->miny;
    	$maxx = $ext->maxx;
    	$maxy = $ext->maxy;
    
    	if ($point->x && $point->y){
    		$x = $point->x;
    		$y = $point->y;
    
    		$dpp_x = ($maxx-$minx)/$width;
    		$dpp_y = ($maxy-$miny)/$height;
    
    		$x = $minx + $dpp_x*$x;
    		$y = $maxy - $dpp_y*$y;
    	}
    	$pt[0] = $x;
    	$pt[1] = $y;
    	return $pt;
    }  

}
?>