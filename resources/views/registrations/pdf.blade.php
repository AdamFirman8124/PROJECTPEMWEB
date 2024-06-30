<!DOCTYPE html>
<html>
<head>
    <title>Rekap Peserta Seminar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #0000;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #A675E4;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #F2F2F2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Rekap Peserta Seminar</h1>
    <table>
        <thead>
            <tr>
                <th>No Identitas</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telepon</th>
                <th>Asal Instansi</th>
                <th>Info</th>
                <th>Topik Seminar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $registration)
            <tr>
                <td>{{ $registration->identitas }}</td>
                <td>{{ $registration->name }}</td>
                <td>{{ $registration->email }}</td>
                <td>{{ $registration->phone }}</td>
                <td>{{ $registration->instansi }}</td>
                <td>{{ $registration->info }}</td>
                <td>{{ $registration->seminar->topik }}</td>
                <td>{{ $registration->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
