<?php
    $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $mData['data']['tipo_rerporte'] }}</title>
</head>
<style>
    html {
        margin: 0;
    }

    /** Defina ahora los márgenes reales de cada página en el PDF **/
    body {
        font-family: "Times New Roman", serif;
        margin-top: 3cm;
        margin-left: 2cm;
        margin-right: 2cm;
        margin-bottom: 2cm;
    }

    /** Definir las reglas del encabezado **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2.6cm;
    }

     /** Definir las reglas del pie de página **/
    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2.5cm;
        text-align: center;
    }
</style>

<body>

    <!--- Se tuvo que colocar primero el footer pr temas de conflicto con css. --->
    <footer>
        <hr style="width: 80%;">
        <h5>
            Calle 11 No. 6-47 Consultorio 101. Teléfonos: 608 8713201 - 608 8720511 <br>
            Cel : 313 2856336 Neiva - Huila. <br>
            Email: consultoriodoctorpuentes@gmail.com
        </h5>
    </footer>

    <!-- Defina bloques de encabezado -->
    <header>
        <img src="{{ public_path('img/sistema/logo_centro_oftamologico.jpg') }}" alt="Logo no encontrado" style="margin-left: 15%; float: left; height: 80px; padding-top:0.5cm;">
        <h1 style="float: right; margin-right: 15%; text-align: center;">Dr. Luís Augusto Puentes M. <br>Oftalmólogo</h1>
    </header>

    <!-- Envuelva el contenido de su PDF dentro de una etiqueta principal -->
    <main>
        <br>
        <p>Neiva, {{ $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ; }} </p>
        <p>
            <strong>IDENTIFICACION:</strong>&nbsp;{{ $mData['data']['pacienteCc']}}<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOMBRE:&nbsp;</strong>{{$mData['data']['nombrePaciente']}}
            <br>
            <strong>EDAD:</strong>&nbsp;{{ $mData['data']['edad_fecha_nacimiento']}}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>CIUDAD:&nbsp;</strong>{{$mData['data']['ciudad']}}
            <br>
            <strong>TELEFONO:</strong>&nbsp;{{$mData['data']['telefono']}}
        </p>

        <!--DATA CUERPO -->
        @switch($mData['data']['tipo_rerporte'])
            @case('reporte_evoluciones')
                <h3 style="text-align: center">REPORTE EVOLUCIONES - HISTORIA CLINICA {{ $mData['data']['consecutivo_historia_clinica'] }}</h3>

                @foreach ($mData['data']['evoluciones'] as $evolucion)
                    <p>
                        <strong> {{ $evolucion['evo_fecha_diligenciamiento'] }} </strong>
                    </p>
                    <p>
                        @if ($evolucion['evo_descripcion_evolucion'] != "")
                            DESCRIPCION EVOLUCION: {{ $evolucion['evo_descripcion_evolucion'] }}
                            <br>
                        @endif

                        @if ($evolucion['evo_tratamiento'] != "")
                            TRATAMIENTO: {{ $evolucion['evo_tratamiento'] }}
                            <br>
                        @endif

                        @if ($evolucion['evo_orden_medica'] != "")
                            ORDEN MEDICA: {{ $evolucion['evo_orden_medica'] }}
                            <br>
                        @endif

                        @if ($evolucion['evo_rx_od'] != "")
                            RX: OD: {{ $evolucion['evo_rx_od'] }}
                            <br>
                        @endif

                        @if ($evolucion['evo_rx_oi'] != "")
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OI: {{ $evolucion['evo_rx_oi'] }}
                            <br>
                        @endif

                        @if ($evolucion['evo_adicion'] != "")
                            ADICION: {{ $evolucion['evo_adicion'] }}
                            <br>
                        @endif

                        @if ($evolucion['evo_dp'] != "")
                            DP: {{ $evolucion['evo_dp'] }}
                            <br>
                        @endif

                        @if ($evolucion['evo_observacion'] != "")
                            {{ $evolucion['evo_observacion'] }}
                        @endif
                    </p>
                @endforeach

            @break
        @endswitch

        <div>
            <br> <br> <br>
            <img src="{{ public_path('img/sistema/firma_medico.png') }}" alt="Firma No encontrada" style="height:100px;">
            <p>
                DR.  LUIS AUGUSTO PUENTES MILLAN <br>
                CC. 19.143.147 Bogotá D.C<br>
                Registro No. 8127/76
            </p>
        </div>
    </main>

</body>
</html>
