<?php
error_reporting (E_ERROR | E_WARNING);
setlocale(LC_MONETARY, 'es_MX'); 
?>
@extends('layouts.default')

@section('title')
Bienvenido :: @parent
@stop

@section('content')
<div>
    <div class="panel-default">
    
    <div class="panel-heading">

        <h3 class="panel-title">Busqueda de Predios</h3>
        
    </div>

</div>
    @if(Session::has('mensaje'))

    <h2>{{ Session::get('mensaje') }}</h2>

    @endif
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/theme.default.css') }}
    {{ HTML::script('js/jquery-1.4.3.min.js')}}
    {{ HTML::script('js/checks.js')}}
   
   
        <script>
        //mostrar  ocultatr vistaa
            function SINO(cual) {
            var elElemento=document.getElementById(cual);
            if(elElemento.style.display == 'block') 
            {
                elElemento.style.display = 'none';
                 } else {
                    elElemento.style.display = 'block';
                 }
            }
            //activar boton
        function validar(obj){
    var d = document.formulario;
    if(obj.checked==true){
        d.boton.disabled = false;
        d.date1.disabled = false;
    }else{
        d.boton.disabled= true;
        d.date1.disabled= true;
    }
}

        </script>


<script type="text/javascript">
    // jQuery
$(document).ready(function(){ 
  
    $('#alternar-respuesta-ej5').toggle( 
  
        // Primer click
        function(e){ 
            $('#respuesta-ej5').slideDown();
            $(this).text('Ocultar respuesta');
            e.preventDefault();
        }, // Separamos las dos funciones con una coma
      
        // Segundo click
        function(e){ 
            $('#respuesta-ej5').slideUp();
            $(this).text('Ver respuesta');
            e.preventDefault();
        }
  
    );
  
});
</script>
    <div class="panel-body">
             {{ Form::open(array('class' => 'busqueda',
                    'role' => 'form',
                    'method'=>'BuscarController@index',
                    'method' => 'GET',
                    'url'=>'/ejecucion'

                    ))
        }}

        <div class="input-group">
            <table class="table">
                <tr>
                    <th>{{Form::label('Clave Catastral:') }}</th>
                    <th>{{Form::label('Nombre Propietario:') }}</th>
                    <th>{{Form::label('Mayor a:') }}</th>
                    <th>{{Form::label('Menor a:') }}</th>
                    <th>{{Form::label('Municipio:') }}</th>
                    <th>{{Form::label('Periodo de Adeudo:') }}</th>
                    <th>{{Form::label('Registros a mostrar:') }}</th>
                </tr>
                <tr>
                    <td>
            
            {{ Form::text('clave',null, array('class' => 'form-control focus', 'placeholder'=>'xx-xxx-xxx-xxxx-xxxxxx', 'autofocus'=> 'autofocus', 'pattern'=> '\d{2}[\-]\d{3}[\-]\d{3}[\-]\d{4}[\-]\d{6}'))  }}
                    </td>
                    <td>
            
            {{ Form::text('nombre',null, array('class' => 'form-control focus', 'placeholder'=>'Nombre')) }}
                    </td>
                   
                    <td>
            
            {{ Form::number('mayor',null, array('class' => 'form-control focus', 'placeholder'=>'Mayor a :'))  }}
                    </td> 
            <td>
             
            {{ Form::number('menor',null, array('class' => 'form-control focus', 'placeholder'=>'Menor a :'))  }}
                    </td>

            {{$errors->first("predios")}}
                    <td>
           
            <select name="municipio" class="form-control"  >
            <option value=''>Elija un municipio...</option>
            @foreach($municipio as $row) 
            <option value="{{$row->municipio}}">{{$row->nombre_municipio}}</option>
            @endforeach
        </select>
                    </td>
                    
                    <td>
                    {{Form::input('date', 'date', null, ['class' => 'form-control', 'placeholder' => 'Date'])}}
                    </td> 
                    <td>
            
            {{Form::select('paginado', array('10' => '10', '20' => '20', '30' => '30', '40' => '40', '50' => '50','60' => '60'))}}
                    </td>
                </tr>
                <tr>
                        <td>{{ Form::submit('Buscar', array('class' => 'btn btn-primary')) }}</td>
                        <td>{{ Form::reset('Limpiar', array('class' => 'btn btn-primary')) }} </td>
                </tr>
            </table>
            </div>
        <br/>
         
         <br>
      
        {{ Form::close() }}
    </div>
    <br>
    <br>
    <br>
   
    @if(count($vale) == 0)
        <div class="panel-body">
            <h3><p> {{$mensaje;}}</p></h3>


        </div>
    @endif
    
    @if(count($vale) > 0)
    {{ Form::open(array('url' => 'cartainv', 'method' => 'post', 'name' => 'formulario'))}}
    {{$date = new DateTime();}} 

    <div class="panel-default">

    <div class="panel-heading">

        <h3 class="panel-title">Resultados de la busqueda</h3>
        
    </div>

    <table  id="myTable" class="table">
     <thead>
        <tr>
                <th width="100" ><P align="center">{{ Form::checkbox('checkMain', 'checkMain', false, array('name' => 'checktodos'))}}</P></th>
                <th width="500"><P align="center">Clave Catastral</P></th>
                <th width="700"><P align="center">Nombre Propietario</P></th>
                <th width="200"><P align="center">Municpio</P></th>
                <th width="500"><P align="center">Calle No.</P></th>
                <th width="400"><P align="center">Colonia</P></th>
                <th width="400"><P align="center">Codigo Postal</P></th>
                <th width="700"><P align="center">Periodo Mas Antiguo</P></th>
                <th width="350"><P align="center">Monto Adeudo</P></th>
                <th width="250"><P align="center">Estatus</P></th>
        </tr>
    </thead>
    <tbody>
        <tr>
       <div class="preload_users">
       </div>
           <?php $i=0;
           //print_r($vale);

            ?>

             @foreach ($vale as $key  ) 
            <?php $i++ ?>
                <?php $val= str_replace('(', '',$key[0]);?>
            <td align="center">
             {{ Form::checkbox('clave'.$i, $key[0], false, ['onclick'=>'validar(this)'], array('id' => 'checkAll'))}}
              <!--  <a href="hoja/{{$row->clave;}}/{{$row->nombre;}}/{{$row->municipio;}}/{{$row->impuesto;}}" class="btn btn-xs btn-info" title="Reimprimir">Generar Carta Invitación<i class="fa fa-file-text-o"></i></a>-->
            </td>
            <td align="center">
                <!-- CLAVE -->
                {{$calve=$val;}}
            </td>
            <td align="center">
                <!-- NOMBRE -->
                 <?php $val2= str_replace('"', '',$key[1]); ?>
                {{$mun=$val2;}}
            </td>
            <td align="center">
                <!-- MUNICIPIO -->
               {{$mun=$key[2];}}
            </td>
            <td align="center">
                <!-- FUNC -->
               <?php $val3= str_replace('"', '',$key[3]); ?>
                {{$mun=$val3;}}
            </td>
            <td align="center">
                <!-- MONT1 -->
                <?php $val4= str_replace('"', '',$key[4]); ?>
                {{$mun=$val4;}}
            </td>
            <td align="center">
               <!-- MONTO2-->
            </td>
            <td align="center">
                <!-- -->
                <?php $val1= str_replace(')', '',$key[7]); ?>
                {{$mun=$val1;}}
            </td>
            <td align="center">
                <!-- CLAVE -->
                $ {{$mun=$key[5];}}
            </td>
            <td align="center">
               <?php $mon= money_format('%i', $key[6]) . "\n"; ?>
                $ {{$mon}}
            </td>         
        </tr>
        @endforeach
   
        </tr>
    </tbody>
    </table>

   {{ $paginator->appends(Request::except('page'))->links() }}
                    
</div>
</div>
<br>
<div>

{{Form::label('Fecha Emision Carta Invitacion: ') }}
{{Form::input('date', 'date1', $date->format('d/m/Y') , array('disabled', 'required' ))}}

</div>
<div>
    {{Form::label('Ejecutores:') }}
     <select name="ejecutores" class="form-control">
            @foreach($catalogo as $row) 
            <option value="{{$row->id_ejecutor}}">{{$row->cargo}}</option>
            @endforeach
        </select>
   
</div>
<br>
{{ Form::submit('Generar Carta Invitacion', array('class' => 'btn btn-primary', 'name' => 'boton', 'disabled')) }}
{{ Form::close() }}

 @endif

<br><br><br>
@stop
