@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
            <a href="{{ url('admin/status/form') }}" class="btn btn-success pull-right ">Add</a> &nbsp; &nbsp; &nbsp;
                <div class="card-title">{{ $title }}</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                @foreach($tableHeadings as $tableHeading)
                                <th class="wd-15p">{{ $tableHeading }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($statuses) > 0)
                            @foreach($statuses as $status)
                            <tr>
                                <td>{{ $status->title }}</td>
                                <td>{{ $status->emoji }}</td>
                                <td>
                                    <div class="material-switch">
                                        <input id="status{{ $status->id }}" onclick="redirectToStatus({{ $status->id }}, {{ $status->status }})" name="status" type="checkbox" {{ $status->status == 1 ? 'checked' : '' }}/>
                                        <label for="status{{ $status->id }}" class="label-success"></label>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteStatus({{ $status->id }})">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  
    function redirectToStatus(id, status) {
    
        window.location.href = "{{ url('admin/status/update') }}/" + id + "/" + status; 

    }

    function deleteStatus(id) {
        window.location.href = "{{ url('admin/status/delete') }}/" + id;
    }
</script>

@endsection