@extends('layouts.app')

@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach
        </ul>
    </div>
@endif
<div class="row justify-content-center"> 
<div class="card col-md-8">
	<div class="card-body ">

        <h5 class="card-title fw-bolder mb-3">Ubah Data Player {{ $data->nickname }}</h5>

		<form method="post" action="{{ route('player.update', $data->nickname) }}">
			@csrf
            <div class="mb-3">
                <label for="id_player" class="form-label">ID Player</label>
                <input type="text" class="form-control" id="id_player" name="id_player" value="{{ $data->id_player }}" disabled >
            </div>
			<div class="mb-3">
                <label for="nickname" class="form-label">Nickname </label>
                <input type="text" class="form-control" id="nickname" name="nickname" value="{{ $data->nickname }}">
            </div>
            <div class="mb-3 ">
                <label for="roles" class="form-label">Role </label>
                <input type="text" class="form-control" id="roles" name="roles" value="{{ $data->roles }}">
            </div>

            <div class="mb-3">
                <label for="id_team" class="form-label">ID Team</label>
                <input type="text" class="form-control" id="id_team" name="id_team" value="{{ $data->id_team }}">

            </div>
            <div class="mb-3">
                <label for="id_divisi" class="form-label">ID Divisi</label>
                <input type="text" class="form-control" id="id_divisi" name="id_divisi" value="{{ $data->id_divisi }}">

            </div>

			<div class="text-center">
				<input type="submit" class="btn btn-success" value="Ubah" />
			</div>
		</form>
	</div>
</div>
</div>
@stop