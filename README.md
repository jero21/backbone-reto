<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Solución del reto

- El reso se abordó con una solución de Laravel + MongoDB
- Se exportaron todos los datos en formato excel desde https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx
- Luego se transformaron los datos a formato json para posteriormente subirlos a una cuenta MongoDB Cloud.

- Desde Laravel se instalaron los packages necesarios para trabajar con mongodb, así poder usar eloquent.
- Se creó un controlador: BackbonesApiController donde la funcioón usada fue show($zip_code)
- Se creó un modelo con los atributos correspondientes.
- Se creó el endpint api/zip_codes/{zip_code}
- Se probaron localmente los tiempos de respeusta de mongodb (se usó un cluster gratuit)

- Finalmente se usó heroku para hacer el deploy de la api.

## Endpoint

- https://reto-backbone.herokuapp.com/api/zip_codes/25013
