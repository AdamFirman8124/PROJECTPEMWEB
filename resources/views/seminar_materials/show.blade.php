<!DOCTYPE html>
<html>
<head>
    <title>View Seminar Material</title>
</head>
<body>
    <h1>View Seminar Material</h1>

    <p>ID: {{ $seminarMaterial->material_id }}</p>
    <p>Seminar ID: {{ $seminarMaterial->seminar_id }}</p>
    <p>File Path: {{ $seminarMaterial->file_path }}</p>
    <p>Description: {{ $seminarMaterial->description }}</p>

    <a href="{{ route('seminar_materials.index') }}">Back to List</a>
    <a href="{{ route('seminar_materials.edit', $seminarMaterial->material_id) }}">Edit</a>

    <form action="{{ route('seminar_materials.destroy', $seminarMaterial->material_id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</body>
</html>
