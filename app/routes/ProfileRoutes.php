<?php
/**
 * Created by David.
 */

/**
 * Rutas para el profile del usuario
 */

Route::get('profile/mis-datos', array(
    'as' => 'profle.mis-datos',
    'uses' => 'ProfileController@index',
    'before' => 'auth'
));

Route::get('profile/editar', array(
    'as' => 'profle.editar',
    'uses' => 'ProfileController@edit',
    'before' => 'auth'
));