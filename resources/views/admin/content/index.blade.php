@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">{{ $title }}</div>
    </div>
    <div class="card-body">
        <form action="{{ url('admin/content/update', $content->type) }}" method="post"> @csrf
            <div class="row">
                <div class="col-md-12">
                    <textarea class="content" required name="content">{{ $content->content }}</textarea>
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection