@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('createPost') }}" method="post">
            @csrf
                <div class="form-group">
                    <textarea name="status" rows="3"
                              class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                              placeholder="Что у вас нового?"></textarea>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Поделиться</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">

        </div>
    </div>
@endsection
