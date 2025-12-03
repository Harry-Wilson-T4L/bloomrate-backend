@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{ $title }}</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                @foreach($tableHeadings as $tableHeading)
                                <th class="wd-15p">{{ $tableHeading }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($users) > 0)
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>
                                    @if(!empty($user->profile_image)) 
                                    <a href="{{ asset($user->profile_image) }}" target="_blank">
                                        <img src="{{ asset($user->profile_image) }}" with="50" height="60">
                                    </a>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->profession }}</td>
                                <td>{{ $user->status->emoji }} {{ $user->status->title }}</td>
                                <td>{{ $user->country }}</td>
                                <td>{{ $user->state }}</td>
                                <td>{{ $user->city }}</td>
                                <td>{{ empty($user->social_type) ? 'Email' : ucfirst($user->social_type) }}</td>
                                <td>
                                    <div class="material-switch">
                                        <input id="status{{ $user->id }}" onclick="redirectToBlock({{ $user->id }}, {{ $user->is_blocked }})" name="is_block" type="checkbox" {{ $user->is_blocked == 1 ? 'checked' : '' }}/>
                                        <label for="status{{ $user->id }}" class="label-success"></label>
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
    function redirectToBlock(id, block) {
        window.location.href = "{{ url('admin/users/block') }}" + "/" + id + "/" + block; 
    }
</script>

@endsection