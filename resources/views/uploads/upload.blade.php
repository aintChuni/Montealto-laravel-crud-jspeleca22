<form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="image">Choose an image:</label>
    <input type="file" name="image" id="image" required>
    <button type="submit">Upload</button>
</form>


@if (session('path'))
    <h3>Uploaded Image:</h3>
    <img src="{{ asset('storage/' . session('path')) }}" alt="Uploaded Image" style="max-width: 300px;">
@endif