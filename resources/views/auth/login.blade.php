@extends('layout')

@section('content')
    <div style="margin-top:10%" class="row">
        <div class="column column-50 column-offset-25">
            <h1>Bitte melde dich an</h1>
            <form class="login" method="POST" action="{{ route('authenticate') }}">
                @csrf
                <fieldset>
                    <label for="name">Dein Vorname</label>
                    <input name="name" type="text">
                    <button type="submit" class="button-primary">Anmelden</button>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
