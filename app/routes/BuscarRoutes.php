<?php
//pantalla principal de carta invvitacion
Route::controller("/ejecucion/", "Ejecucion_BuscarController");
Route::controller("/ejecuciones", "Ejecucion_BuscaController");
//pantalla principal de seguimiento ejecucion
Route::get("/seguimiento", "Ejecucion_SeguimientoController@getIndex");
Route::get("/busquedas", "Ejecucion_SeguimientobusController@getIndex");
//vista para capturar datos ejecucion fiscal
Route::get('/vista', function()
{
	 return View::make('ejecucion.carta');
});
//ruta para pdf
Route::post("/cartainv/{clave?}/{date1?}", "CartaInvitacion_PdfController@get_pdf");

Route::controller("/consulta", "Consulta_ConsultaController");

 Route::get('/ejecucion/modal/{idrequerimiento}', 'Ejecucion_SeguimientobusController@modal');
