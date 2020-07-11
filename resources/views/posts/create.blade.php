@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form method="POST" action="{{ url('posts') }}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="form-group">
					<legend>Create New Post <span style="float: right;"><a href="{{ url('csv') }}">Upload CSV</a></span></legend> 
				</div>
				<div class="form-group">
					<label for="title">Title <span>*</span></label>
					<input type="text" name="title" class="form-control">
					@if($errors->has('title'))
					<label>{{ $errors->first('title') }}</label>
					@endif
				</div>
				<div class="form-group">
					<label for="title">Body <span>*</span></label>
					<textarea name="body" class="form-control"></textarea>
					@if($errors->has('body'))
					<label>{{ $errors->first('body') }}</label>
					@endif
				</div>
				<div class="form-group">
					<label for="title">File Upload </label>
					<input type="file" name="postImage" class="form-control">
				</div>
				<a href="{{ url('posts') }}" class="btn btn-secondry">Cancel</a>
				<input type="submit" name="post" value="Post" class="btn btn-success">
			</form>
		</div>
		
	</div>
</div>
@endsection