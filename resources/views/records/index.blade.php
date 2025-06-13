<!-- resources/views/records/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Data Record</title>
</head>
<body>
    <h1>Semua Record</h1>

    <a href="{{ route('records.create') }}">Tambah Record Baru</a>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Weight</th>
                <th>Height</th>
                <th>BMI</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->gender }}</td>
                    <td>{{ $record->age }}</td>
                    <td>{{ $record->weight }}</td>
                    <td>{{ $record->height }}</td>
                    <td>{{ $record->bmi }}</td>
                    <td>{{ $record->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>