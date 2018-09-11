@extends('layouts.app')

@section('title', 'Easy School')

<style type="text/css">
    .panel-default>.panel-heading {
        color: #fff !important;
        background-color: #0097a7 !important;
        border-color: #ddd;
    }
</style>

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">প্রতিষ্ঠানের তালিকা</div>
                <div class="panel-body">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <td>নাম</td>
                                <td>ইআইআইএন</td>
                                <td>অ্যাাডমিশন</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schools as $school)
                            <tr>
                                <td>{{ $school->name }}</td>
                                <td>{{ $school->eiin }}</td>
                                <td>
                                    @if($school->isadmissionon == 0)

                                    @elseif($school->isadmissionon == 1)
                                    <a href="{{ route('admissions.apply', $school->id) }}" class="btn btn-success btn-sm">আবেদন করুন</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
