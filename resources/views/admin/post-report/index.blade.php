@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
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
                            @if(count($reports) > 0)
                            @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->user->full_name }}</td>
                                <td>{{ $report->user->email }}</td>

                                <td>
                                    @if(!empty($report->user->profile_image)) 
                                    <a href="{{ asset($report->user->profile_image) }}" target="_blank">
                                        <img src="{{ asset($report->user->profile_image) }}" with="50" height="60">
                                    </a>
                                    @endif
                                </td>
                                <td>{{ $report->post->title }}</td>
                                <td>{{ ucfirst($report->post->post_type) }}</td>
                                <td>{{ ucfirst($report->post->user->full_name) }}</td>
                                <td>{{ ucfirst($report->post->user->email) }}</td>
                                <td>{{ $report->created_at }}</td>
                                <td>
                                    <div class="material-switch">
                                        <input id="status{{ $report->id }}" onclick="redirectToStatus({{ $report->post->id }}, {{ $report->post->is_block }})" name="status" type="checkbox" {{ $report->post->is_block == 1 ? 'checked' : '' }}/>
                                        <label for="status{{ $report->id }}" class="label-success"></label>
                                    </div>
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
        window.location.href = "{{ url('admin/reported/post-update') }}/" + id + "/" + status; 
    }
</script>

@endsection