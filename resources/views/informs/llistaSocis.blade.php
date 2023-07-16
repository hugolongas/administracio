<!doctype html>
<html lang="es">

<head>    
<style>
        #socis {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #socis td, #customers th {
          border: 1px solid #000;
          padding: 8px;
        }
        #socis th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #E7E7E7;
          color: black;
        }
        </style>
</head>

<body>
    <h2>Llistat de Socis</h2>
    <div>
        <table id="socis">
            <thead>
                <tr>
                    <th>Núm Soci</th>
                    <th>Nom Soci</th>
                    <th></th>
            </thead>
            <tbody>
                @foreach($socis as $soci)
                <tr>
                    <td>{{$soci->member_number}}</td>
                    <td>{{$soci->name}} {{$soci->surname}} {{$soci->second_surname}}</td>
                    <td> </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>