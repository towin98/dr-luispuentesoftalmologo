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
    <title>{{ $mData['tipo_rerporte'] }}</title>
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
            Calle 11 No. 6-47 Consultorio 101. Teléfonos: 8720511 - 8713201 <br>
            Cel : 3132856336 Neiva - Huila. <br>
            Email: PUENTES222@HOTMAIL.COM
        </h5>
    </footer>

    <!-- Defina bloques de encabezado -->
    <header>
        <img src="{{ public_path('img/sistema/logo_centro_oftamologico.png') }}" alt="Logo no encontrado" style="margin-left: 15%; float: left; height: 80px; padding-top:0.5cm;">
        <h1 style="float: right; margin-right: 15%; text-align: center;">Dr. Luís Augusto Puentes M. <br>Oftamólogo</h1>
    </header>


    <!-- Envuelva el contenido de su PDF dentro de una etiqueta principal -->
    <main>
        <br><br>
        <p>Neiva, {{ $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ; }} </p>
        <br><br><br>
        <p><strong>
            PACIENTE: {{ $mData['data']['nombrePaciente'] }}</strong><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>C.C:</strong> {{ $mData['data']['pacienteCc'] }}
        </p> <br> <br> <br>

        <!--DATA CUERPO -->
        @switch($mData['tipo_rerporte'])
            @case('formula')
                <p style="word-wrap:break-word;"> TRATAMIENTO: {{ $mData['data']['tratamiento'] }} </p>
            @break

            @case('orden_medica')
                <p style="word-wrap:break-word;"> SE ORDENA: {{ $mData['data']['orden_medica'] }} </p>
            @break

            @case('rx')
                <p>RX: OD: {{ $mData['data']['rx_od'] }} <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OI: {{ $mData['data']['rx_oi'] }}
                </p>
                <p> ADICION {{ $mData['data']['adicion'] }} </p>
                <p>DP: {{ $mData['data']['dp'] }} </p>
                <p style="word-wrap:break-word;">{{ $mData['data']['observacion'] }}</p>
            @break
        @endswitch

        <br> <br> <br> <br>
        @switch($mData['tipo_rerporte'])
            @case('orden_medica')
            <p>
                CALE 18 No. 5-96 <br>
                CENTRO OFTAMOLOGICO SURCOLOMBIANO <br>
                TEL 8755849 - 8750332
            </p>
            @break
        @endswitch
        <br> <br> <br> <br> <br> <br>
        <img src="{{ public_path('img/sistema/firma_medico.png') }}" alt="Firma No encontrada" style="height:100px;">
        <p>
            DR.  LUIS AUGUSTO PUENTES MILLAN <br>
            CC. 19.143.147 Bogotá <br>
            Registro No. 8127/76
        </p>
    </main>

</body>
</html>