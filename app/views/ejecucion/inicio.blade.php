<?php
error_reporting (E_ERROR | E_WARNING);
?>
@extends('layouts.default')

@section('title')
Bienvenido :: @parent
@stop

@section('content')
<div>
    <div class="default">
    
    <div class="panel-heading">

        <h4 class="panel-title">Busqueda de Predios</h4>
        
    </div>

</div>
    @if(Session::has('mensaje'))

    <h2>{{ Session::get('mensaje') }}</h2>

    @endif
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/theme.default.css') }}
    {{ HTML::script('js/jquery-1.4.3.min.js')}}
    {{ HTML::script('js/checks.js')}}
    {{ HTML::script('js/jquery.tablesorter.widgets.js')}}
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
        <script>
            $ ( función () { 
  $ ( "#myTable" ). tablesorter (); 
});
        </script>
<script>
    $ ( función () { 
  $ ( "#myTable" ). tablesorter ({ sortList :  [[ 0 , 0 ],  [ 1 , 0 ]]  }); 
});
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
             {{ Form::open(array(
                    'role' => 'form',
                    'method'=>'BuscarController@index',
                    'method' => 'GET',
                    'url'=>'/ejecucion'

                    ))
        }}

        <div class="input-group">
            <table class="input-group">
                <tr>
                    <td>
            {{Form::label('Clave Catastral:') }}
            {{ Form::text('clave',null, array('class' => 'form-control focus', 'placeholder'=>'xxx-xxxx-xxxxxx', 'autofocus'=> 'autofocus', 'pattern'=> '\d{3}[\-]\d{4}[\-]\d{6}'))  }}
                    </td>
                    <td>
            {{Form::label('Nombre Propietario:') }}
            {{ Form::text('nombre',null, array('class' => 'form-control focus', 'placeholder'=>'Nombre')) }}
                    </td>
             </tr>
             <tr>
             <td>
            {{Form::label('Rango Valor Catastral:') }}
            {{ Form::number('mayor',null, array('class' => 'form-control focus', 'placeholder'=>'Mayor a :', 'autofocus'=> 'autofocus'))  }}
                    </td> 
            <td>
             {{Form::label('  .') }}
            {{ Form::number('menor',null, array('class' => 'form-control focus', 'placeholder'=>'Menor a :', 'autofocus'=> 'autofocus'))  }}
                    </td>

            {{$errors->first("predios")}}
                </tr>
            </table>

        </div>
        <br>
        <div><p> 
            
            <a class="btn btn-primary" href="javascript:void(0);" onclick="SINO('demo1')">Mas opciones</a></p></div>
        <br>


        <br>
        <div id="demo1" style="display:none;">

            <table class="table datatable">
                <tr>
                    <td>
            {{Form::label('Municipio:') }}
            {{ Form::text('municipio','', array('class' => 'form-control focus', 'placeholder'=>'Mucipio', 'autofocus'=> 'autofocus', 'pattern'=> '[a-zA-Z]*')) }}
                    </td>
                    <td>
            {{Form::label('Colonia:') }}
            {{ Form::text('colonia',null, array('class' => 'form-control focus', 'placeholder'=>'Colonia', 'autofocus'=> 'autofocus')) }}
                    </td>
                    <td>
            {{Form::label('No. Calle:') }}
            {{ Form::text('calle',null, array('class' => 'form-control focus', 'placeholder'=>'No. de calle', 'autofocus'=> 'autofocus')) }}
                    </td>
                    <td>
            {{Form::label('Codigo Postal:') }}
            {{ Form::text('cp',null, array('class' => 'form-control focus', 'placeholder'=>'Codigo postal', 'autofocus'=> 'autofocus')) }}
                    </td>
                    <td>
                       
            {{Form::label('Estatus:') }}
             {{Form::select('size', array('PC' => 'PC', 'CI' => 'CI', 'RC' => 'RC', 'RI' => 'RI', 'RA' => 'RA', 
             'RN' => 'RN', 'DC' => 'DC', 'DI' => 'DI', 'DA' => 'DA', 'DN' => 'DN', 'EC' => 'EC', 'EI' => 'EI',
              'EA' => 'EA', 'EN' => 'EN', 'SS' => 'SS', 'XE' => 'XE', 'XC' => 'XC', 'XP' => 'XP'))}}
            
                    </td>
                    <td>
            {{Form::label('Periodo de Adeudo:') }}
                    </td>
                    <td>
                    {{Form::input('date', 'date', null, ['class' => 'form-control', 'placeholder' => 'Date'])}}
                    </td>
                </tr>
            </table>
            </div>
        <br/>
         
         <br>
        {{ Form::submit('Buscar', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
    <br>
    <br>
    <br>
    @if(($busqueda))
    {{ Form::open(array('url' => 'cartainv', 'method' => 'post', 'name' => 'formulario'))}}
    <div class="default">

    <div class="panel-heading">

        <h4 class="panel-title">Resultados</h4>
        
    </div>

    <table border="1"  id="myTable" class="tablesorter">
     <thead>
        <tr>
                <th width="700">{{ Form::checkbox('checkMain', 'checkMain', false, array('name' => 'checktodos'))}}</th>
                <th width="500">Clave Catastral</th>
                <th width="700">Nombre Propietario</th>
                <th width="200">Municpio</th>
                <th width="500">Calle No.</th>
                <th width="400">Colonia</th>
                <th width="400">Codigo Postal</th>
                <th width="700">Periodo Mas Antiguo</th>
                <th width="350">Monto Adeudo</th>
                <th width="250">Estatus</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        @if(!empty($busqueda))
           <?php $i=0 ?>
            @foreach($busqueda as $row)
            <?php $i++ ?>
                
            <td>
             {{ Form::checkbox('clave'.$i, $row->clave, false, ['onclick'=>'validar(this)'], array('id' => 'checkAll'))}}
              <!--  <a href="hoja/{{$row->clave;}}/{{$row->nombre;}}/{{$row->municipio;}}/{{$row->impuesto;}}" class="btn btn-xs btn-info" title="Reimprimir">Generar Carta Invitación<i class="fa fa-file-text-o"></i></a>-->
            </td>
            <td>
                {{$row->clave}}
            </td>
            <td>
                {{$row->nombre;}}
            </td>
            <td>
                
            </td>
            <td>
                {{$row->calle;}}
            </td>
            <td>
                {{ $row->colonia;}}
            </td>
            <td>
                {{$row->cp;}}
            </td>
            <td>
                {{$row->minimo;}}
            </td>
            <td>
                {{$row->impuesto;}}
            </td>
            <td>
                {{$row->estatus;}}
            </td>         
        </tr>
        @endforeach
   
        </tr>
    </tbody>
    </table>

    
                    
</div>
</div>
<br>
<div>

{{Form::label('Fecha Emision Carta Invitacion: ') }}
{{Form::input('date', 'date1', null, array('disabled', 'required' ))}}

    {{Form::label('Ejecutores:') }}
     <select name="ejecutores" class="form-control" autofocus="autofocus" >
            @foreach($catalogo as $row) 
            <option value="{{$row->id_ejecutor}}">{{$row->cargo}}</option>
            @endforeach
        </select>
   
</div>
<br>
{{ Form::submit('Generar Carta Invitacion', array('class' => 'btn btn-primary', 'name' => 'boton', 'disabled')) }}
{{ Form::close() }}

 @endif
 @endif

<br><br><br>
@stop
