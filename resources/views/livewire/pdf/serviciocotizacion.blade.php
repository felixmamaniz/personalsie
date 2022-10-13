<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movimiento Diario General-Resumen</title>



    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

    <style>
        .estilostable {
        width: 100%;
        font-size: 12px;
        border-spacing: 0px;
        color: black;
        }
        .estilostable .tablehead{
            background-color: #dbd4d4;
            font-size: 10px;
        }
        .estilostable2 {
        width: 100%;
        font-size: 9px;
        border-spacing: 0px;
        color: black;
        }
        .estilostable2 .tablehead{
            background-color: white;
        }
        .fnombre{
            border: 0.5px solid rgb(204, 204, 204);
        }
        .filarow{
            border: 0.5px solid rgb(204, 204, 204);
            width: 20px;
            text-align: center;
        }
        .filarowpp{
            border: 0.5px solid rgb(204, 204, 204);
            width: 53px;
            text-align: center;
            font-size: 8px;
        }
        .filarownombre{
            border: 0.5px solid rgb(204, 204, 204);
            width: 150px;
        }
    
        .filarowx{
            border: 0.5px solid rgb(255, 255, 255);
            width: 100%;
            text-align: center;
        }
    
    
        </style>
</head>
<body style="padding: 30PX;">
    <table class="filarowx">
        <tbody>
            <tr class="filarowx">
                <td rowspan="2">
                    <img src={{asset('storage/icons/logo.png')}} width="60" height="60">
                </td>
                <td rowspan="2" class="text-right">
                    <h1><b>COTIZACION - SERVICIOS</b></h1>
                </td>
            </tr>
        </tbody>
    </table>

<hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(229, 140, 40);">

<table class="estilostable">
    <tbody>
        <tr>
            <td colspan="2" class="text-left">
                <h4><b>SOLUCIONES INFORMATICAS EMANUEL</b></h4>
                Av. America casi G.Rene Moreno
            </td>
            <td class="text-right">
                <b>FECHA:</b>
                <br>
               {{-- <b> NOMBRE USUARIO:</b> --}}
            </td>
            <td class="text-left">
                Jueves 13/10/2022
                <br>
                {{-- Juan Mendoza --}}
            </td>
        </tr>
    </tbody>
</table>


<hr style="height:3px;border:none;color:rgb(189, 188, 188);background-color:rgb(229, 140, 40);">




<table class="estilostable">
    <tbody>
        <tr>
            <td colspan="2" class="text-center">
                <h4><b>PARA:</b></h4>
            </td>
            <td class="text-left">
                {{-- Nombre --}}
                {{-- <br> --}}
                MAXAM IT SERVICES S.R.L.
            </td>
        </tr>
    </tbody>
</table>


<br>

    <div class="">
        <table class="estilostable" style="font-size: 15px;">
            <thead>
                <tr class="tablehead">
                    <th class="text-center">TIPO</th>
                    <th class="text-center">NOMBRE PRODUCTO</th>
                    <th class="text-center">MODELO</th>
                    <th class="text-center">CANTIDAD</th>
                    <th class="text-center">PRECIO</th>
                    <th class="text-center">TOTAL</th>
            </thead>
            <tbody>

                <tr>
                    <td>
                        Servicio
                    </td>
                    <td>
                        Laptop Dell
                    </td>
                    <td>
                        LATITUDE E5450
                    </td>
                    <td class="text-center">
                        1
                    </td>
                    <td>
                        100,00 Bs
                    </td>
                    <td>
                        <b>100,00 Bs</b>
                    </td>
                </tr>

                <tr>
                    <td>
                        Venta Repuesto
                    </td>
                    <td>
                        Bateria
                    </td>
                    <td>
                        -
                    </td>
                    <td class="text-center">
                        1
                    </td>
                    <td>
                        500,00 Bs
                    </td>
                    <td>
                        <b>500,00 Bs</b>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>TOTAL</b>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                    <td class="text-center">
                        2
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <b>600,00 Bs</b>
                    </td>
                </tr>

            </tbody>
        </table>




</body>
</html>