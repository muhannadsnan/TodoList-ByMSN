@extends('master')
@section('title', 'Todos') 

@section('content') 

    <Todo :todos="{{$todos}}"/>    

@endsection

@section('styles')
    <style>
        //.class1{}
        //.class2{}
    </style>
@endsection

@section('scripts')
    {{--<script>
        $(document).ready(function(){
            
        });
    </script> --}}
@endsection