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
	<div class="card-body">

        <h5 class="card-title fw-bolder mb-3">Ubah Data Team {{ $data->id_team }}</h5>

		<form method="post" action="{{ route('team.update', $data->id_team) }}">
			@csrf
            <div class="mb-3">
                <label for="id_team" class="form-label">ID Team</label>
                <input type="text" class="form-control" id="id_team" name="id_team" value="{{ $data->id_team }}" disabled >
            </div>
			<div class="mb-3">
                <label for="nama_team" class="form-label">Nama Team</label>
                <input type="text" class="form-control" id="nama_team" name="nama_team" value="{{ $data->nama_team }}">
            </div>
            <div class="mb-3">
                <label for="tahun_dibentuk " class="form-label">Tahun Dibentuk</label>
                <input type="text" class="form-control" id="tahun_dibentuk" name="tahun_dibentuk" value="{{ $data->tahun_dibentuk }}">
            </div>

			<div class="text-center">
				<input type="submit" class="btn btn-success" value="Ubah" />
			</div>
		</form>
	</div>
</div>
</div>

@stop