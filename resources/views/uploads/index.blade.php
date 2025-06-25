@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-3">
    <div class="col-md-12">
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Image Gallery
                </div>
                <div class="float-end">
                    <a href="{{ route('images.create') }}" class="btn btn-primary btn-sm">Upload New Image</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse ($images as $image)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="{{ $image->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $image->name }}</h5>
                                <div class="btn-group">
                                    <a href="{{ route('images.show', $image->id) }}" class="btn btn-primary btn-sm">View</a>
                                    <form action="{{ route('images.destroy', $image->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-md-12">
                        <p class="text-center">No images found.</p>
                    </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $images->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection