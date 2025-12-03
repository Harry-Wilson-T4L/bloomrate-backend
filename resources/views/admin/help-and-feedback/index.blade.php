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
                            @if(count($helpAndFeedbacks) > 0)
                            @foreach($helpAndFeedbacks as $helpAndFeedback)
                            <tr>
                                <td>{{ $helpAndFeedback->user->full_name }}</td>
                                <td>{{ $helpAndFeedback->user->email }}</td>
                                <td>
                                    @if(!empty($helpAndFeedback->user->profile_image)) 
                                    <a href="{{ asset($helpAndFeedback->user->profile_image) }}" target="_blank">
                                        <img src="{{ asset($helpAndFeedback->user->profile_image) }}" with="50" height="60">
                                    </a>
                                    @endif
                                </td>
                                <td>{{ $helpAndFeedback->subject }}</td>
                                <td>{{ $helpAndFeedback->description }}</td>
                                <td>
                                    @if(!empty($helpAndFeedback->images))
                                    @php $images = json_decode($helpAndFeedback->images); @endphp
                                    @foreach($images as $image) 
                                        <a href="{{ asset($image) }}" target="_blank">
                                            <img src="{{ asset($image) }}" with="50" height="60">
                                        </a>
                                    @endforeach
                                    @endif
                                </td>
                                <td>{{ $helpAndFeedback->created_at }}</td>
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

@endsection