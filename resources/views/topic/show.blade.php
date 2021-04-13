@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <topic :topic="{{ $topic }}"></topic>
            </div>
        </div>
    </div>
@endsection
