@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form action="{{ url('posts', ['id' => $post->id]) }}" method="post">
	        {{ csrf_field() }}
	        <input type="hidden" name="_method" value="PUT">
				<div class="form-group">
					<legend>Create New Post</legend>
				</div>
				<div class="form-group">
					<label for="title">Title <span>*</span></label>
					<input type="text" name="title" class="form-control" value="{{ $post->title }}">
					@if($errors->has('title'))
					<label>{{ $errors->first('title') }}</label>
					@endif
				</div>
				<div class="form-group">
					<label for="title">Body <span>*</span></label>
					<textarea name="body" class="form-control">{{ $post->body }}</textarea>
					@if($errors->has('body'))
					<label>{{ $errors->first('body') }}</label>
					@endif
				</div>
				<a href="{{ url('posts') }}" class="btn btn-secondry">Cancel</a>
				<input type="submit" name="Update" value="Update" class="btn btn-success">
			</form>
		</div>
		
	</div>
</div>
@endsection