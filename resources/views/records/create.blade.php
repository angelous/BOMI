<!-- resources/views/records/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Record</title>
</head>
<body>
    <h1>Input Data Tubuh</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('records.store') }}">
        @csrf
        <label>Gender:</label>
        <input type="text" name="gender" value="{{ old('gender') }}"><br><br>

        <label>Age:</label>
        <input type="number" name="age" value="{{ old('age') }}"><br><br>

        <label>Weight (kg):</label>
        <input type="number" step="0.1" name="weight" value="{{ old('weight') }}"><br><br>

        <label>Height (cm):</label>
        <input type="number" step="0.1" name="height" value="{{ old('height') }}"><br><br>

        <button type="submit">Simpan</button>
    </form>

    <br>
    <a href="{{ route('records.index') }}">Lihat Semua Record</a>
</body>
</html>