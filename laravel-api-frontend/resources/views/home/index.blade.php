@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title mb-3">Daftar Sports</h1>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="{{ route('sports.create') }}" class="btn btn-primary">Create Sport</a>
                    </div>

                    @if (!empty($sports))
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sports as $sport)
                                    <tr>
                                        <td>{{ $sport['id'] ?? '' }}</td>
                                        <td>{{ $sport['name'] ?? '' }}</td>
                                        <td>{{ $sport['description'] ?? '' }}</td>
                                        <td>
                                            @if (!empty($sport['image']))
                                                <img src="{{ $sport['image'] }}" alt="{{ $sport['name'] }}" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $sport['created_at'] ?? '' }}</td>
                                        <td>{{ $sport['updated_at'] ?? '' }}</td>
                                        <td>
                                            <form action="{{ route('sports.destroy', $sport['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sport?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="card-text">Belum ada data sports.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection