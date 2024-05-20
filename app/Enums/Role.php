<?php

namespace App\Enums;


//Este enum es solo para manejar los roles creados
//por defecto con la app, ya que no tenemos forma
//de crear dinamicamente opciones para los nuevos
//roles creados
enum Role: string
{
    case SUPER_ADMIN = 'Super Administrador';
    case ADMIN = 'Administrador';
    case CAPTURISTA = 'Capturista';
    case REUTRONIC = 'Reutronic';
}