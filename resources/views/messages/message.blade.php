@extends('layouts.default')

@section('content')
<h4 style="text-align: center">Диалог с {{ $username }}</h4>



    <div class="content" style="text-align: center">
        <form action='{{ route('sendMessage', ['username' => $username]) }}' method="post">
            @csrf
            <textarea name="message" class="row-3 form-control"></textarea>
            @if ($errors->has('message'))
                <div class="help-block text-danger">
                    {{ $errors->first('message') }}
                </div>
            @endif
            <input type="submit" class="btn btn-primary my-3" value="Отправить сообщение">
        </form><br>
    </div>

@endsection
