@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="mb-0 card-title">{{ $title }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ url('admin/interests/form') }}" method="post"> @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" value="{{ old('title') }}" name="title" required>
                    </div>
                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection