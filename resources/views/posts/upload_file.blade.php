@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- Form -->
			<form method='post' action='{{ url("uploadFile") }}' enctype='multipart/form-data' >
				{{ csrf_field() }}
				<input type='file' name='file'>
				<input type='submit' name='submit' value='Import'>
			</form>
		</div>
	</div>
</div>			
@endsection