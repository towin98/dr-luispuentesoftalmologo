<?php

namespace Database\Seeders;

use App\Models\parametro\ocupacion;
use Illuminate\Database\Seeder;

class ocupacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrOcupaciones = [
            [
                'codigo'     => '0011',
                'descripcion'=> 'Miembros del poder ejecutivo y legislativo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0012',
                'descripcion'=> 'Personal directivo de la administración pública',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0013',
                'descripcion'=> 'Directores y gerentes generales de servicios financieros, de telecomunicaciones y otros servicios a las empresas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0014',
                'descripcion'=> 'Directores y gerentes generales de salud, educación, servicio social, comunitario y organizaciones de membresía',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0015',
                'descripcion'=> 'Directores y gerentes generales de comercio, medios de comunicación y otros servicios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0016',
                'descripcion'=> 'Directores y gerentes generales de producción de bienes, servicios públicos, transporte y construcción',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0017',
                'descripcion'=> 'Directores y gerentes generales de servicios y procesos de negocio',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0111',
                'descripcion'=> 'Gerentes financieros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0112',
                'descripcion'=> 'Gerentes de talento humano',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0113',
                'descripcion'=> 'Gerentes de compras y adquisiciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0114',
                'descripcion'=> 'Gerentes de otros servicios administrativos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0121',
                'descripcion'=> 'Gerentes de seguros, bienes raíces y corretaje financiero',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0122',
                'descripcion'=> 'Gerentes de banca, crédito e inversiones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0123',
                'descripcion'=> 'Gerentes de otros servicios a las empresas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0131',
                'descripcion'=> 'Gerentes de empresas de telecomunicaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0132',
                'descripcion'=> 'Gerentes de servicios de correo y mensajería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0211',
                'descripcion'=> 'Gerentes de ingeniería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0212',
                'descripcion'=> 'Gerentes de investigación y desarrollo en ciencias naturales y aplicadas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0213',
                'descripcion'=> 'Gerentes de sistemas de información y procesamiento de datos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0311',
                'descripcion'=> 'Gerentes de servicios a la salud',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0411',
                'descripcion'=> 'Gerentes de programas de política social y de salud',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0412',
                'descripcion'=> 'Gerentes de programas de política de desarrollo económico',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0413',
                'descripcion'=> 'Gerentes de programas de política educativa',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0414',
                'descripcion'=> 'Otros gerentes de administración pública',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0421',
                'descripcion'=> 'Administradores de educación superior y formación para el trabajo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0422',
                'descripcion'=> 'Directores y administradores de educación básica y media',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0423',
                'descripcion'=> 'Gerentes de servicios social, comunitario y correccional',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0511',
                'descripcion'=> 'Gerentes de biblioteca, museo y galería de arte',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0512',
                'descripcion'=> 'Gerentes de medios de comunicación y artes escénicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0513',
                'descripcion'=> 'Directores de programas de esparcimiento y administradores de deportes',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0611',
                'descripcion'=> 'Gerentes de ventas, mercadeo y publicidad',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0612',
                'descripcion'=> 'Gerentes de comercio exterior',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0621',
                'descripcion'=> 'Gerentes de comercio al por menor',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0631',
                'descripcion'=> 'Gerentes de restaurantes y servicios de alimentos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0632',
                'descripcion'=> 'Gerentes de servicios hoteleros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0641',
                'descripcion'=> 'Oficiales de las fuerzas militares',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0642',
                'descripcion'=> 'Oficiales de policía',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0643',
                'descripcion'=> 'Oficiales de bomberos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0644',
                'descripcion'=> 'Oficiales del cuerpo de custodia y vigilancia',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0651',
                'descripcion'=> 'Gerentes de otros servicios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0711',
                'descripcion'=> 'Gerentes de producción primaria (excepto agricultura)',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0712',
                'descripcion'=> 'Gerentes de producción agrícola, pecuaria, acuícola y pesquero',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0811',
                'descripcion'=> 'Gerentes de construcción',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0812',
                'descripcion'=> 'Gerentes de transporte y distribución',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0813',
                'descripcion'=> 'Gerentes de logística',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0814',
                'descripcion'=> 'Gerentes cadena de suministro',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0815',
                'descripcion'=> 'Gerentes y directores de servicios portuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0821',
                'descripcion'=> 'Gerentes de operación de instalaciones físicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0822',
                'descripcion'=> 'Gerentes de mantenimiento',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0911',
                'descripcion'=> 'Gerentes de producción industrial',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '0912',
                'descripcion'=> 'Gerentes de empresas de servicios públicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1111',
                'descripcion'=> 'Contadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1112',
                'descripcion'=> 'Analistas, asesores y agentes de mercado financiero',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1113',
                'descripcion'=> 'Auditores financieros y contables',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1121',
                'descripcion'=> 'Profesionales de talento humano',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1122',
                'descripcion'=> 'Profesionales en organización y administración de las empresas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1123',
                'descripcion'=> 'Evaluadores de competencias laborales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1124',
                'descripcion'=> 'Archivistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1125',
                'descripcion'=> 'Profesionales de formación y desarrollo de personal',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1131',
                'descripcion'=> 'Profesionales en operaciones y servicios portuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1211',
                'descripcion'=> 'Supervisores de empleados de apoyo administrativo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1212',
                'descripcion'=> 'Jefes y supervisores de entidades financieras',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1213',
                'descripcion'=> 'Supervisores y coordinadores de procesos de negocio, empleados de información y servicio al cliente',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1214',
                'descripcion'=> 'Supervisores de empleados de correo y mensajería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1215',
                'descripcion'=> 'Supervisores de almacenamiento, inventario y distribución',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1216',
                'descripcion'=> 'Coordinadores y supervisores en operaciones y servicios portuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1221',
                'descripcion'=> 'Asistentes administrativos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1222',
                'descripcion'=> 'Administradores de propiedad horizontal',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1223',
                'descripcion'=> 'Asistentes de talento humano',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1224',
                'descripcion'=> 'Asistentes de compras',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1225',
                'descripcion'=> 'Asistentes de juzgados, tribunales y afines',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1226',
                'descripcion'=> 'Funcionarios de aduanas, impuestos, inmigración y seguridad social',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1227',
                'descripcion'=> 'Asistentes de comercio exterior',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1229',
                'descripcion'=> 'Técnicos en archivística',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1231',
                'descripcion'=> 'Asistentes contables',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1232',
                'descripcion'=> 'Analistas, asistentes y asesores de servicios financieros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1233',
                'descripcion'=> 'Evaluadores, ajustadores, analistas y liquidadores de seguros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1234',
                'descripcion'=> 'Agentes de aduana',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1235',
                'descripcion'=> 'Asistentes financieros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1236',
                'descripcion'=> 'Asistentes de tesorería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1241',
                'descripcion'=> 'Asistentes de mercadeo, publicidad y comunicaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1311',
                'descripcion'=> 'Secretarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1313',
                'descripcion'=> 'Recepcionistas y operadores de conmutador',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1321',
                'descripcion'=> 'Digitadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1322',
                'descripcion'=> 'Transcriptores y relatores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1323',
                'descripcion'=> 'Digitalizadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1331',
                'descripcion'=> 'Auxiliares contables, de tesorería y financieros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1332',
                'descripcion'=> 'Cajeros de servicios financieros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1333',
                'descripcion'=> 'Auxiliares de servicios financieros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1334',
                'descripcion'=> 'Auxiliares de cartera y cobranzas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1335',
                'descripcion'=> 'Auxiliares de nómina y prestaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1336',
                'descripcion'=> 'Avaluadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1341',
                'descripcion'=> 'Auxiliares administrativos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1342',
                'descripcion'=> 'Auxiliares de talento humano',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1343',
                'descripcion'=> 'Auxiliares de tribunales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1344',
                'descripcion'=> 'Auxiliares de archivo y registro',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1345',
                'descripcion'=> 'Auxiliares administrativos en salud',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1346',
                'descripcion'=> 'Auxiliares de aduana',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1351',
                'descripcion'=> 'Auxiliares de biblioteca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1352',
                'descripcion'=> 'Auxiliares de publicación y afines',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1353',
                'descripcion'=> 'Auxiliares de información y servicio al cliente',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1354',
                'descripcion'=> 'Auxiliares de estadística y encuestadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1361',
                'descripcion'=> 'Auxiliares de correo y servicio postal',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1362',
                'descripcion'=> 'Carteros y mensajeros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1371',
                'descripcion'=> 'Auxiliares de almacén',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1372',
                'descripcion'=> 'Auxiliares de compras e inventarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1373',
                'descripcion'=> 'Operadores de radio y despachadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1374',
                'descripcion'=> 'Programadores de rutas y tripulaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '1375',
                'descripcion'=> 'Operadores telefónicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2111',
                'descripcion'=> 'Físicos y astrónomos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2112',
                'descripcion'=> 'Químicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2113',
                'descripcion'=> 'Geólogos, geoquímicos y geofísicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2114',
                'descripcion'=> 'Meteorólogos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2115',
                'descripcion'=> 'Oceanógrafos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2116',
                'descripcion'=> 'Profesionales en metrología',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2121',
                'descripcion'=> 'Biólogos, botánicos, zoólogos y relacionados',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2122',
                'descripcion'=> 'Expertos forestales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2123',
                'descripcion'=> 'Expertos agrícolas y pecuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2124',
                'descripcion'=> 'Administradores ambientales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2125',
                'descripcion'=> 'Extensionistas agropecuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2126',
                'descripcion'=> 'Agroecólogos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2131',
                'descripcion'=> 'Ingenieros en construcción y obras civiles',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2132',
                'descripcion'=> 'Ingenieros mecánicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2133',
                'descripcion'=> 'Ingenieros electricistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2134',
                'descripcion'=> 'Ingenieros electrónicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2135',
                'descripcion'=> 'Ingenieros químicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2136',
                'descripcion'=> 'Ingenieros de automatización e instrumentación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2137',
                'descripcion'=> 'Ingenieros de telecomunicaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2138',
                'descripcion'=> 'Ingenieros navales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2141',
                'descripcion'=> 'Ingenieros industriales y de fabricación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2142',
                'descripcion'=> 'Ingenieros de materiales y metalurgia',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2143',
                'descripcion'=> 'Ingenieros de minas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2144',
                'descripcion'=> 'Ingenieros de petróleos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2145',
                'descripcion'=> 'Ingenieros de tecnologías de la información',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2146',
                'descripcion'=> 'Otros ingenieros nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2147',
                'descripcion'=> 'Ingenieros y productores de audio y sonido',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2151',
                'descripcion'=> 'Arquitectos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2152',
                'descripcion'=> 'Urbanistas y planificadores del uso del suelo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2153',
                'descripcion'=> 'Ingenieros topográficos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2154',
                'descripcion'=> 'Diseñadores industriales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2161',
                'descripcion'=> 'Matemáticos, estadísticos y actuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2171',
                'descripcion'=> 'Analistas de sistemas informáticos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2172',
                'descripcion'=> 'Administradores de servicios de tecnologías de la información',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2173',
                'descripcion'=> 'Desarrolladores de aplicaciones informáticas y digitales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2211',
                'descripcion'=> 'Técnicos en química aplicada',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2212',
                'descripcion'=> 'Técnicos en geología y minería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2213',
                'descripcion'=> 'Técnicos en meteorología',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2214',
                'descripcion'=> 'Técnicos en metrología',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2221',
                'descripcion'=> 'Técnicos en ciencias biológicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2222',
                'descripcion'=> 'Técnicos en recursos naturales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2223',
                'descripcion'=> 'Técnicos en prevención, gestión y control ambiental',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2224',
                'descripcion'=> 'Gemólogos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2231',
                'descripcion'=> 'Técnicos en construcción y arquitectura',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2232',
                'descripcion'=> 'Técnicos en mecánica y construcción mecánica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2233',
                'descripcion'=> 'Técnicos en fabricación industrial',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2241',
                'descripcion'=> 'Técnicos en electricidad',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2242',
                'descripcion'=> 'Técnicos en electrónica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2243',
                'descripcion'=> 'Técnicos en automatización e instrumentación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2244',
                'descripcion'=> 'Técnicos en instrumentos de aeronavegación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2245',
                'descripcion'=> 'Técnicos en telecomunicaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2252',
                'descripcion'=> 'Dibujantes técnicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2253',
                'descripcion'=> 'Topógrafos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2254',
                'descripcion'=> 'Técnicos en cartografía',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2261',
                'descripcion'=> 'Inspectores de pruebas no destructivas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2262',
                'descripcion'=> 'Inspectores de sanidad, seguridad y salud ocupacional',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2263',
                'descripcion'=> 'Inspectores de construcción',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2264',
                'descripcion'=> 'Inspectores de equipos de transporte e instrumentos de medición',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2265',
                'descripcion'=> 'Inspectores de productos agrícolas, pecuarios y de pesca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2266',
                'descripcion'=> 'Inspectores de riego agrícola',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2267',
                'descripcion'=> 'Coordinadores de sistemas integrados de gestión',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2271',
                'descripcion'=> 'Pilotos, ingenieros e instructores de vuelo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2272',
                'descripcion'=> 'Controladores de tráfico aéreo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2273',
                'descripcion'=> 'Capitanes y oficiales de cubierta',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2274',
                'descripcion'=> 'Oficiales de máquinas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2275',
                'descripcion'=> 'Controladores de tráfico ferroviario y marítimo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2276',
                'descripcion'=> 'Despachadores de aeronaves',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2281',
                'descripcion'=> 'Técnicos en tecnologías de la información',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2311',
                'descripcion'=> 'Asistentes en saneamiento ambiental',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2312',
                'descripcion'=> 'Auxiliares de laboratorio',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2313',
                'descripcion'=> 'Auxiliares de seguridad en el trabajo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2314',
                'descripcion'=> 'Operarios de exploración geofísica y geológica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2321',
                'descripcion'=> 'Auxiliares en automatización e instrumentación industrial',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '2331',
                'descripcion'=> 'Técnicos en asistencia y soporte de tecnologías de la información',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3111',
                'descripcion'=> 'Médicos especialistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3112',
                'descripcion'=> 'Médicos generales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3113',
                'descripcion'=> 'Odontólogos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3114',
                'descripcion'=> 'Veterinarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3121',
                'descripcion'=> 'Optómetras',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3122',
                'descripcion'=> 'Otras ocupaciones profesionales en diagnóstico y tratamiento de la salud nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3131',
                'descripcion'=> 'Farmacéuticos y químicos farmacéuticos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3132',
                'descripcion'=> 'Dietistas y nutricionistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3141',
                'descripcion'=> 'Audiólogos y terapeutas del lenguaje',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3142',
                'descripcion'=> 'Fisioterapeutas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3143',
                'descripcion'=> 'Terapeutas ocupacionales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3151',
                'descripcion'=> 'Enfermeros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3152',
                'descripcion'=> 'Instrumentadores quirúrgicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3161',
                'descripcion'=> 'Psicólogos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3211',
                'descripcion'=> 'Técnicos de laboratorio médico y patología',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3212',
                'descripcion'=> 'Técnicos en terapia respiratoria y cardiovascular',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3213',
                'descripcion'=> 'Técnicos y tecnólogos en imágenes diagnósticas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3214',
                'descripcion'=> 'Técnicos en radioterapia',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3216',
                'descripcion'=> 'Técnicos en medicina nuclear',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3217',
                'descripcion'=> 'Regentes de farmacia',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3222',
                'descripcion'=> 'Higienistas dentales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3231',
                'descripcion'=> 'Técnicos en mecánica oftálmica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3232',
                'descripcion'=> 'Practicantes de medicina alternativa',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3233',
                'descripcion'=> 'Asistentes de ambulancia y otras ocupaciones paramédicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3234',
                'descripcion'=> 'Técnicos en desarrollo de productos para la asistencia en salud',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3235',
                'descripcion'=> 'Guardavidas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3311',
                'descripcion'=> 'Auxiliares en enfermería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3312',
                'descripcion'=> 'Auxiliares de salud oral',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3313',
                'descripcion'=> 'Auxiliares en salud pública',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3314',
                'descripcion'=> 'Auxiliares de laboratorio clínico',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3315',
                'descripcion'=> 'Auxiliares en servicios farmacéuticos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3316',
                'descripcion'=> 'Otros auxiliares de servicios a la salud nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '3317',
                'descripcion'=> 'Auxiliares en mecánica dental',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4111',
                'descripcion'=> 'Jueces',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4112',
                'descripcion'=> 'Abogados',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4121',
                'descripcion'=> 'Profesores de educación superior',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4122',
                'descripcion'=> 'Especialistas en procesos pedagógicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4131',
                'descripcion'=> 'Profesores e instructores de formación para el trabajo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4141',
                'descripcion'=> 'Profesores de educación básica secundaria y media',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4142',
                'descripcion'=> 'Profesores de educación básica primaria',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4143',
                'descripcion'=> 'Profesores de preescolar',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4144',
                'descripcion'=> 'Orientadores educativos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4145',
                'descripcion'=> 'Pedagogo reeducador',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4152',
                'descripcion'=> 'Trabajadores sociales y consultores de familia',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4153',
                'descripcion'=> 'Ministros del culto',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4161',
                'descripcion'=> 'Sociólogos, antropólogos y afines',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4162',
                'descripcion'=> 'Filósofos, filólogos y afines',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4171',
                'descripcion'=> 'Consultores, investigadores y analistas de política económica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4172',
                'descripcion'=> 'Consultores y funcionarios de desarrollo económico y comercial',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4173',
                'descripcion'=> 'Investigadores, consultores y funcionarios de políticas sociales de salud y de educación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4174',
                'descripcion'=> 'Funcionarios de programas exclusivos de la administración pública',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4175',
                'descripcion'=> 'Investigadores, consultores y funcionarios de políticas de ciencias naturales y aplicadas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4176',
                'descripcion'=> 'Profesionales en gestión de riesgo de desastres',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4181',
                'descripcion'=> 'Profesionales en ciencias forenses',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4211',
                'descripcion'=> 'Asistentes en servicios social y comunitario',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4212',
                'descripcion'=> 'Consejeros de servicios de empleo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4213',
                'descripcion'=> 'Instructores y profesores de personas en condición de discapacidad',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4214',
                'descripcion'=> 'Otros instructores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4215',
                'descripcion'=> 'Ocupaciones religiosas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4221',
                'descripcion'=> 'Investigadores criminalísticos y judiciales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4222',
                'descripcion'=> 'Asistentes legales y afines',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '4311',
                'descripcion'=> 'Auxiliares de educación para la primera infancia',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5111',
                'descripcion'=> 'Bibliotecólogos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5112',
                'descripcion'=> 'Restauradores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5114',
                'descripcion'=> 'Curadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5121',
                'descripcion'=> 'Escritores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5122',
                'descripcion'=> 'Editores y redactores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5123',
                'descripcion'=> 'Periodistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5124',
                'descripcion'=> 'Traductores e intérpretes',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5125',
                'descripcion'=> 'Ocupaciones profesionales en relaciones públicas y comunicaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5126',
                'descripcion'=> 'Publicistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5131',
                'descripcion'=> 'Productores, directores artísticos, coreógrafos y ocupaciones relacionadas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5132',
                'descripcion'=> 'Intérpretes musicales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5134',
                'descripcion'=> 'Compositores coreográficos de danza',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5135',
                'descripcion'=> 'Actores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5136',
                'descripcion'=> 'Pintores, escultores y otros artistas visuales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5137',
                'descripcion'=> 'Directores e investigadores musicales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5138',
                'descripcion'=> 'Autores y compositores musicales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5141',
                'descripcion'=> 'Diseñadores gráficos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5211',
                'descripcion'=> 'Ocupaciones técnicas relacionadas con museos y galerías',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5212',
                'descripcion'=> 'Técnicos en biblioteca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5213',
                'descripcion'=> 'Técnicos en promoción y animación a la lectura y la escritura',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5221',
                'descripcion'=> 'Fotógrafos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5222',
                'descripcion'=> 'Operadores de cámara de cine y televisión',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5223',
                'descripcion'=> 'Técnicos en diseño y arte gráfico',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5224',
                'descripcion'=> 'Técnicos en transmisión de radio y televisión',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5226',
                'descripcion'=> 'Otras ocupaciones técnicas en cine, televisión y artes escénicas nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5227',
                'descripcion'=> 'Ocupaciones de asistencia en cine, televisión y artes escénicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5228',
                'descripcion'=> 'Productores de campo para cine y televisión',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5231',
                'descripcion'=> 'Locutores de radio, televisión y otros medios de comunicación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5232',
                'descripcion'=> 'Curadores y supervisores musicales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5233',
                'descripcion'=> 'Otros artistas nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5242',
                'descripcion'=> 'Diseñadores de interiores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5243',
                'descripcion'=> 'Diseñadores de teatro, moda, exhibición y otros diseñadores creativos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5245',
                'descripcion'=> 'Patronistas de productos de tela, cuero y piel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5246',
                'descripcion'=> 'Ilustradores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5247',
                'descripcion'=> 'Graficadores de imágenes computarizadas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5251',
                'descripcion'=> 'Deportistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5252',
                'descripcion'=> 'Entrenadores y preparadores físicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5253',
                'descripcion'=> 'Árbitros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5261',
                'descripcion'=> 'Ceramistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5262',
                'descripcion'=> 'Tejedores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5263',
                'descripcion'=> 'Artesanos trabajos en maderables y no maderables',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5264',
                'descripcion'=> 'Artesanos trabajos en cuero',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5265',
                'descripcion'=> 'Artesanos trabajos en metal',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5266',
                'descripcion'=> 'Otros artesanos nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5267',
                'descripcion'=> 'Artesanos trabajos en vidrio',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5268',
                'descripcion'=> 'Artesanos trabajos en materiales líticos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5269',
                'descripcion'=> 'Artesanos trabajos en papel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5311',
                'descripcion'=> 'Operadores de audio y sonido',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5312',
                'descripcion'=> 'Ejecutantes musicales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5313',
                'descripcion'=> 'Auxiliares de producción de audio y sonido',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5321',
                'descripcion'=> 'Interpretes para la danza',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '5331',
                'descripcion'=> 'Desfibradores de fibras naturales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6211',
                'descripcion'=> 'Supervisores de ventas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6212',
                'descripcion'=> 'Administradores y supervisores de comercio al por menor',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6213',
                'descripcion'=> 'Supervisores de servicios de alimentos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6214',
                'descripcion'=> 'Supervisores de personal de manejo doméstico',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6215',
                'descripcion'=> 'Sommeliers',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6216',
                'descripcion'=> 'Supervisores de servicios de alojamiento y hospedaje',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6221',
                'descripcion'=> 'Suboficiales de las fuerzas militares',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6222',
                'descripcion'=> 'Suboficiales y nivel ejecutivo de la policía',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6223',
                'descripcion'=> 'Supervisores de vigilantes',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6224',
                'descripcion'=> 'Suboficiales del cuerpo de custodia y vigilancia',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6225',
                'descripcion'=> 'Suboficiales de bomberos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6226',
                'descripcion'=> 'Poligrafistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6231',
                'descripcion'=> 'Agentes y corredores de seguros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6232',
                'descripcion'=> 'Agentes de bienes raíces',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6233',
                'descripcion'=> 'Vendedores de ventas técnicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6234',
                'descripcion'=> 'Agentes de compras e intermediarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6235',
                'descripcion'=> 'Representante de servicios especializados BPO',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6236',
                'descripcion'=> 'Administradores de comunidades virtuales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6237',
                'descripcion'=> 'Agentes y promotores artísticos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6238',
                'descripcion'=> 'Coordinadores y productores de eventos y espectáculos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6241',
                'descripcion'=> 'Chefs',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6251',
                'descripcion'=> 'Auxiliares de vuelo y sobrecargos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6261',
                'descripcion'=> 'Tanatopractores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6262',
                'descripcion'=> 'Coordinadores de servicios funerarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6263',
                'descripcion'=> 'Intérpretes de lengua de señas colombiana - español',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6264',
                'descripcion'=> 'Guías-intérpretes',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6265',
                'descripcion'=> 'Guías de turismo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6271',
                'descripcion'=> 'Tatuadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6311',
                'descripcion'=> 'Vendedores de ventas no técnicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6312',
                'descripcion'=> 'Auxiliares de promoción artística',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6313',
                'descripcion'=> 'Asesores integrales de imagen',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6321',
                'descripcion'=> 'Vendedores de mostrador',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6322',
                'descripcion'=> 'Mercaderistas e impulsadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6323',
                'descripcion'=> 'Cajeros de comercio',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6324',
                'descripcion'=> 'Modelos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6331',
                'descripcion'=> 'Agentes de viajes',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6332',
                'descripcion'=> 'Empleados de ventas y servicios de líneas aéreas, marítimas y terrestres',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6334',
                'descripcion'=> 'Empleados de recepción hotelera',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6341',
                'descripcion'=> 'Informadores turísticos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6342',
                'descripcion'=> 'Recreadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6343',
                'descripcion'=> 'Operadores de juegos mecánicos y de salón',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6344',
                'descripcion'=> 'Auxiliares de producción audiovisual, de eventos y espectáculos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6351',
                'descripcion'=> 'Cortadores de carne para comercio mayorista y al detal',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6352',
                'descripcion'=> 'Panaderos y pasteleros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6353',
                'descripcion'=> 'Meseros y capitán de meseros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6354',
                'descripcion'=> 'Bartender',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6355',
                'descripcion'=> 'Cocineros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6356',
                'descripcion'=> 'Baristas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6357',
                'descripcion'=> 'Transformadores de caña panelera',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6361',
                'descripcion'=> 'Inspectores de policía',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6362',
                'descripcion'=> 'Funcionarios de regulación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6363',
                'descripcion'=> 'Auxiliares de policía',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6364',
                'descripcion'=> 'Bomberos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6365',
                'descripcion'=> 'Guardianes de prisión',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6366',
                'descripcion'=> 'Soldados',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6367',
                'descripcion'=> 'Vigilantes y guardias de seguridad',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6368',
                'descripcion'=> 'Técnicos investigadores criminalísticos y judiciales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6371',
                'descripcion'=> 'Acompañantes domiciliarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6372',
                'descripcion'=> 'Auxiliares del cuidado de niños',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6373',
                'descripcion'=> 'Peluqueros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6374',
                'descripcion'=> 'Trabajadores del cuidado de animales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6375',
                'descripcion'=> 'Auxiliares de servicios funerarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6376',
                'descripcion'=> 'Astrólogos, adivinadores y relacionados',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6377',
                'descripcion'=> 'Manicuristas y pedicuristas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6378',
                'descripcion'=> 'Cosmetólogos esteticistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6379',
                'descripcion'=> 'Maquilladores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6381',
                'descripcion'=> 'Agentes de tránsito',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6382',
                'descripcion'=> 'Técnicos operativos de tránsito',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6611',
                'descripcion'=> 'Trabajadores de estación de servicio',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6612',
                'descripcion'=> 'Otras ocupaciones elementales de las ventas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6621',
                'descripcion'=> 'Ayudantes de establecimientos de alimentos y bebidas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6631',
                'descripcion'=> 'Aseadores y servicio doméstico',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6632',
                'descripcion'=> 'Aseadores especializados y fumigadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6633',
                'descripcion'=> 'Recolectores de material para reciclaje',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6641',
                'descripcion'=> 'Auxiliares de servicios a viajeros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6642',
                'descripcion'=> 'Auxiliares de servicios de recreación y deporte',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6643',
                'descripcion'=> 'Empleados de lavandería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6644',
                'descripcion'=> 'Otras ocupaciones elementales de los servicios nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6645',
                'descripcion'=> 'Auxiliares de servicios hoteleros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6646',
                'descripcion'=> 'Operarios de cementerios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '6647',
                'descripcion'=> 'Anfitriones turísticos locales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7111',
                'descripcion'=> 'Administradores de explotación acuícola y jefes de laboratorio de cultivo o producción acuícola',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7211',
                'descripcion'=> 'Supervisores de minería y canteras',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7212',
                'descripcion'=> 'Supervisores de perforación y servicios, pozos de petróleo y gas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7213',
                'descripcion'=> 'Inspectores de sistemas e instalaciones de gas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7214',
                'descripcion'=> 'Supervisores y analistas de producción de hidrocarburos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7221',
                'descripcion'=> 'Supervisores de producción agrícola',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7222',
                'descripcion'=> 'Supervisores de producción pecuaria',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7223',
                'descripcion'=> 'Supervisores de explotación forestal y silvicultura',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7231',
                'descripcion'=> 'Agricultores y administradores agropecuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7232',
                'descripcion'=> 'Contratistas de servicios agrícolas y relacionados',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7233',
                'descripcion'=> 'Supervisores de servicios de jardinería y viverismo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7241',
                'descripcion'=> 'Capitanes y patrones de pesca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7311',
                'descripcion'=> 'Operarios de apoyo y servicios en minería bajo tierra',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7312',
                'descripcion'=> 'Operarios de apoyo y servicios en perforación de petróleo y gas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7313',
                'descripcion'=> 'Mineros de producción bajo tierra',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7314',
                'descripcion'=> 'Perforadores de pozos de gas y petróleo y trabajadores relacionados',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7315',
                'descripcion'=> 'Inspectores de construcción de oleoductos y gasoductos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7316',
                'descripcion'=> 'Operadores de equipo minero',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7317',
                'descripcion'=> 'Operadores de producción de hidrocarburos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7318',
                'descripcion'=> 'Operarios de servicios a pozos de hidrocarburos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7319',
                'descripcion'=> 'Operarios torres de perforación de hidrocarburos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7321',
                'descripcion'=> 'Trabajadores de explotación forestal',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7322',
                'descripcion'=> 'Trabajadores de silvicultura y forestación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7331',
                'descripcion'=> 'Trabajadores agrícolas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7332',
                'descripcion'=> 'Trabajadores pecuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7333',
                'descripcion'=> 'Trabajadores de vivero',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7334',
                'descripcion'=> 'Trabajadores del campo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7335',
                'descripcion'=> 'Trabajadores de plantas de incubación artificial',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7336',
                'descripcion'=> 'Rayadores de caucho',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7337',
                'descripcion'=> 'Operarios de riego agrícola',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7341',
                'descripcion'=> 'Pescadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7342',
                'descripcion'=> 'Operario acuícola',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7343',
                'descripcion'=> 'Técnico acuícola en sistemas de reproducción',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7344',
                'descripcion'=> 'Técnico acuícola en sistemas de levante y engorde',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7611',
                'descripcion'=> 'Obreros y ayudantes de minería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7612',
                'descripcion'=> 'Obreros y ayudantes de producción en pozos de petróleo y gas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7613',
                'descripcion'=> 'Obreros agropecuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '7614',
                'descripcion'=> 'Jardineros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8211',
                'descripcion'=> 'Supervisores de ajustadores de máquinas herramientas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8212',
                'descripcion'=> 'Supervisores de electricidad y telecomunicaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8213',
                'descripcion'=> 'Supervisores de instalación de tuberías',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8214',
                'descripcion'=> 'Supervisores de moldeo de forja y montaje de estructuras metálicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8215',
                'descripcion'=> 'Supervisores de carpintería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8216',
                'descripcion'=> 'Supervisores de mecánica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8217',
                'descripcion'=> 'Supervisores de operación de equipo pesado',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8218',
                'descripcion'=> 'Maestros generales de obra y supervisores de construcción, instalación y reparación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8221',
                'descripcion'=> 'Supervisores de operación de transporte ferroviario',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8222',
                'descripcion'=> 'Supervisores de operación de transporte terrestre (no ferroviario)',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8311',
                'descripcion'=> 'Ajustadores y operadores de máquinas herramientas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8312',
                'descripcion'=> 'Modelistas y matriceros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8321',
                'descripcion'=> 'Electricistas industriales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8322',
                'descripcion'=> 'Electricistas residenciales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8323',
                'descripcion'=> 'Instaladores de redes de energía eléctrica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8324',
                'descripcion'=> 'Técnicos instaladores de redes y líneas de telecomunicaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8325',
                'descripcion'=> 'Auxiliares técnicos de instalación, mantenimiento y reparación de sistemas de telecomunicaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8326',
                'descripcion'=> 'Operarios de mantenimiento y servicio de televisión por cable',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8331',
                'descripcion'=> 'Oficiales fontaneros y plomeros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8332',
                'descripcion'=> 'Instaladores de tuberías para sistemas de extinción de incendios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8333',
                'descripcion'=> 'Instaladores de redes y equipos a gas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8341',
                'descripcion'=> 'Chapistas, caldereros y paileros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8342',
                'descripcion'=> 'Soldadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8343',
                'descripcion'=> 'Montadores de estructuras metálicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8344',
                'descripcion'=> 'Ornamentistas, forjadores y herreros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8345',
                'descripcion'=> 'Tuberos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8351',
                'descripcion'=> 'Carpinteros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8352',
                'descripcion'=> 'Ebanistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8361',
                'descripcion'=> 'Oficiales de construcción',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8362',
                'descripcion'=> 'Trabajadores en concreto, hormigón y enfoscado',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8363',
                'descripcion'=> 'Enchapadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8364',
                'descripcion'=> 'Techadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8365',
                'descripcion'=> 'Instaladores de material aislante',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8366',
                'descripcion'=> 'Pintores y empapeladores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8367',
                'descripcion'=> 'Instaladores de pisos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8368',
                'descripcion'=> 'Revocadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8371',
                'descripcion'=> 'Mecánicos industriales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8372',
                'descripcion'=> 'Mecánicos de maquinaria textil, confección, cuero, calzado y marroquinería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8373',
                'descripcion'=> 'Mecánicos de equipo pesado',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8374',
                'descripcion'=> 'Mecánicos de aviación',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8375',
                'descripcion'=> 'Técnicos de aire acondicionado y refrigeración',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8381',
                'descripcion'=> 'Mecánicos de vehículos automotores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8382',
                'descripcion'=> 'Electricistas de vehículos automotores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8383',
                'descripcion'=> 'Mecánicos de motos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8384',
                'descripcion'=> 'Latoneros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8391',
                'descripcion'=> 'Reparadores de aparatos electrodomésticos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8392',
                'descripcion'=> 'Mecánicos electricistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8393',
                'descripcion'=> 'Auxiliares técnicos en electrónica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8394',
                'descripcion'=> 'Mecánicos de otras pequeñas máquinas y motores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8411',
                'descripcion'=> 'Instaladores residenciales y comerciales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8412',
                'descripcion'=> 'Operarios de mantenimiento de instalaciones de abastecimiento de agua y gas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8413',
                'descripcion'=> 'Vidrieros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8414',
                'descripcion'=> 'Ayudantes electricistas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8415',
                'descripcion'=> 'Ayudantes de mecánica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8416',
                'descripcion'=> 'Otros reparadores nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8421',
                'descripcion'=> 'Tapiceros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8422',
                'descripcion'=> 'Sastres, modistos, peleteros y sombrereros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8423',
                'descripcion'=> 'Zapateros y afines',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8424',
                'descripcion'=> 'Joyeros y relojeros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8425',
                'descripcion'=> 'Tipógrafos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8426',
                'descripcion'=> 'Cerrajeros y afines',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8427',
                'descripcion'=> 'Buzos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8431',
                'descripcion'=> 'Operadores de máquinas estacionarias y equipo auxiliar',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8432',
                'descripcion'=> 'Operadores de plantas de generación y distribución de energía',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8433',
                'descripcion'=> 'Operadores de planta de gas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8441',
                'descripcion'=> 'Operadores de grúa',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8442',
                'descripcion'=> 'Perforadores y operarios de voladura para minería de superficie de canteras y construcción',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8443',
                'descripcion'=> 'Perforadores de pozos de agua',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8451',
                'descripcion'=> 'Operadores de equipo pesado (excepto grúa)',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8452',
                'descripcion'=> 'Operadores de equipo para limpieza de vías y alcantarillado',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8453',
                'descripcion'=> 'Operadores de maquinaria agrícola',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8461',
                'descripcion'=> 'Maquinistas de transporte ferroviario',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8462',
                'descripcion'=> 'Guardafrenos y otros operadores ferroviarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8471',
                'descripcion'=> 'Conductores de vehículos pesados',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8472',
                'descripcion'=> 'Operadores de bus, metro y otros medios de transporte colectivo y masivo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8473',
                'descripcion'=> 'Conductores de vehículos livianos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8474',
                'descripcion'=> 'Conductores de transporte de alimentos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8481',
                'descripcion'=> 'Marineros de cubierta',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8482',
                'descripcion'=> 'Marineros de sala de máquinas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8483',
                'descripcion'=> 'Operadores de pequeñas embarcaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8484',
                'descripcion'=> 'Operarios de rampa de transporte aéreo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8491',
                'descripcion'=> 'Operarios portuarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8492',
                'descripcion'=> 'Operarios de cargue y descargue de materiales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8493',
                'descripcion'=> 'Aparejadores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8611',
                'descripcion'=> 'Ayudantes y obreros de construcción',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8612',
                'descripcion'=> 'Ayudantes de otros oficios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8621',
                'descripcion'=> 'Obreros y ayudantes de obras públicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8622',
                'descripcion'=> 'Ayudantes de transporte automotor',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '8623',
                'descripcion'=> 'Ayudantes y operarios de barrido y mantenimiento de áreas públicas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9111',
                'descripcion'=> 'Directores de planta de procesamiento de alimentos y bebidas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9112',
                'descripcion'=> 'Jefe de laboratorio de alimentos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9211',
                'descripcion'=> 'Supervisores de tratamiento de metales y minerales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9212',
                'descripcion'=> 'Supervisores de procesamiento de químico, petróleo, gas y tratamiento de agua y generación de energía',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9213',
                'descripcion'=> 'Supervisores de procesamiento de alimentos y bebidas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9214',
                'descripcion'=> 'Supervisores de fabricación de productos de plástico y caucho',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9215',
                'descripcion'=> 'Supervisores de procesamiento de la madera y producción de pulpa y papel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9216',
                'descripcion'=> 'Supervisores de procesamiento textil',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9217',
                'descripcion'=> 'Inspectores de control de calidad, procesamiento de alimentos y bebidas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9221',
                'descripcion'=> 'Supervisores de ensamble de vehículos de motor',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9222',
                'descripcion'=> 'Supervisores de fabricación de productos electrónicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9223',
                'descripcion'=> 'Supervisores de fabricación de productos eléctricos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9224',
                'descripcion'=> 'Supervisores de fabricación de muebles y accesorios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9225',
                'descripcion'=> 'Supervisores de fabricación de productos de tela, cuero y piel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9226',
                'descripcion'=> 'Supervisores de impresión y ocupaciones relacionadas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9227',
                'descripcion'=> 'Supervisores de fabricación de otros productos mecánicos y metálicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9228',
                'descripcion'=> 'Supervisores de fabricación y ensamble de otros productos nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9229',
                'descripcion'=> 'Inspectores de vehículos de motor',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9231',
                'descripcion'=> 'Operadores de control central de procesos, tratamiento de metales y minerales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9232',
                'descripcion'=> 'Operadores de procesos, químicos, gas y petróleo',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9233',
                'descripcion'=> 'Operadores de control de procesos, producción de pulpa',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9234',
                'descripcion'=> 'Operadores de control de procesos, fabricación de papel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9241',
                'descripcion'=> 'Impresores de artes gráficas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9242',
                'descripcion'=> 'Pre-prensistas de artes gráficas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9243',
                'descripcion'=> 'Operarios de terminados y acabados de artes gráficas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9311',
                'descripcion'=> 'Operadores de máquinas, tratamiento de metales y minerales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9312',
                'descripcion'=> 'Trabajadores de fundición, moldeadores y macheros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9313',
                'descripcion'=> 'Operadores de fabricación, moldeo y acabado del vidrio',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9314',
                'descripcion'=> 'Operadores de moldeo de arcilla, piedra y concreto',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9315',
                'descripcion'=> 'Inspectores de control de calidad, tratamiento de metales y minerales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9321',
                'descripcion'=> 'Operadores de máquinas de planta química',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9322',
                'descripcion'=> 'Operadores de máquinas para procesamiento de plásticos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9323',
                'descripcion'=> 'Operadores de máquinas y trabajadores relacionados con el procesamiento del caucho',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9324',
                'descripcion'=> 'Operadores de plantas de tratamiento de agua',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9325',
                'descripcion'=> 'Operadores de rellenos sanitarios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9331',
                'descripcion'=> 'Operadores de máquinas para procesamiento de la madera',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9332',
                'descripcion'=> 'Operadores de máquinas para la producción de pulpa',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9333',
                'descripcion'=> 'Operadores de máquinas para la fabricación de papel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9334',
                'descripcion'=> 'Operadores de máquinas para la fabricación de productos de papel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9335',
                'descripcion'=> 'Inspectores de control de calidad, procesamiento de la madera',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9341',
                'descripcion'=> 'Operadores de máquinas para la preparación de fibras textiles',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9342',
                'descripcion'=> 'Operadores de telares y otras máquinas tejedoras',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9343',
                'descripcion'=> 'Operadores de máquinas de tintura, acabado textil y prendas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9344',
                'descripcion'=> 'Analistas de calidad, textiles',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9351',
                'descripcion'=> 'Operadores de máquinas para coser y bordar',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9352',
                'descripcion'=> 'Cortadores de tela, cuero y piel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9353',
                'descripcion'=> 'Operadores de máquinas y trabajadores relacionados con la fabricación de calzado y marroquinería',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9354',
                'descripcion'=> 'Trabajadores del tratamiento de pieles y cueros',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9355',
                'descripcion'=> 'Inspectores de control de calidad, fabricación de productos de tela, piel y cuero',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9361',
                'descripcion'=> 'Operadores de control de procesos y máquinas para la elaboración de alimentos y bebidas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9362',
                'descripcion'=> 'Operarios de planta de beneficio animal',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9363',
                'descripcion'=> 'Operarios de planta de procesamiento y empaque de pescado y mariscos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9364',
                'descripcion'=> 'Operarios de máquinas para la elaboración de productos de tabaco',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9374',
                'descripcion'=> 'Procesadores fotográficos y de películas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9381',
                'descripcion'=> 'Ensambladores de vehículos automotores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9382',
                'descripcion'=> 'Ensambladores de productos electrónicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9383',
                'descripcion'=> 'Ensambladores e inspectores de aparatos y equipo eléctrico',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9384',
                'descripcion'=> 'Ensambladores, fabricantes e inspectores de transformadores y motores eléctricos industriales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9385',
                'descripcion'=> 'Ensambladores e inspectores de productos mecánicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9386',
                'descripcion'=> 'Ensambladores e inspectores de ensamble de aeronaves',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9387',
                'descripcion'=> 'Operadores de máquinas e inspectores de la fabricación de productos y componentes eléctricos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9391',
                'descripcion'=> 'Ensambladores e inspectores de embarcaciones',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9392',
                'descripcion'=> 'Ensambladores e inspectores de muebles y accesorios',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9393',
                'descripcion'=> 'Operarios de acabado de muebles',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9394',
                'descripcion'=> 'Ensambladores de productos plásticos e inspectores',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9395',
                'descripcion'=> 'Operarios de tratamiento térmico y recubrimientos metálicos',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9396',
                'descripcion'=> 'Pintores en procesos de manufactura',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9397',
                'descripcion'=> 'Otros ensambladores e inspectores nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9398',
                'descripcion'=> 'Auxiliares de producción gráfica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9412',
                'descripcion'=> 'Operadores de máquinas para el trabajo de la madera',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9413',
                'descripcion'=> 'Operadores de máquinas para el trabajo del metal',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9414',
                'descripcion'=> 'Operadores de máquinas para forja',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9415',
                'descripcion'=> 'Operadores de máquinas de soldadura',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9416',
                'descripcion'=> 'Operadores de máquinas para la fabricación de otros productos metálicos nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9417',
                'descripcion'=> 'Operadores de máquinas para la fabricación de otros productos nca',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9611',
                'descripcion'=> 'Obreros y ayudantes en el tratamiento de metales y minerales',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9612',
                'descripcion'=> 'Ayudantes en la fabricación metálica',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9613',
                'descripcion'=> 'Obreros y ayudantes de planta química',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9614',
                'descripcion'=> 'Obreros y ayudantes en el procesamiento de la madera y producción de pulpa y papel',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9615',
                'descripcion'=> 'Auxiliares en el procesamiento de alimentos y bebidas',
                'estado'     => 'ACTIVO'
            ],
            [
                'codigo'     => '9616',
                'descripcion'=> 'Otros obreros y ayudantes en fabricación y procesamiento nca',
                'estado'     => 'ACTIVO'
            ]
        ];

        foreach ($arrOcupaciones as $ocupacion) {
            ocupacion::create([
                'codigo'       => $ocupacion['codigo'],
                'descripcion'  => $ocupacion['descripcion'],
                'estado'       => $ocupacion['estado']
            ]);
        }
    }
}
