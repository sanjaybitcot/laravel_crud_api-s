@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">

			<div class="col-md-12"><legend><span style="float: left;">All Posts</span><span style="float: right;"><a href="{{ url('posts/create') }}" class="btn btn-success">Create Post</a></span></legend></div>
			<div class="clearfix"></div>

			@if(session('success_message'))
			<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ session('success_message') }}
			</div>
			@endif

			@if(session('error_message'))
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				{{ session('error_message') }}
			</div>
			@endif
			<div>Total Record: {{ $posts->total() }}</div>
			<table class="table display responsive nowrap">
				<tr>
					<th>Title</th>
					<th>Body</th>
					<th>Image</th>
					<th>Action</th>
				</tr>
				@if($posts)
					@foreach($posts as $post)
						<tr>
							<td>{{ $post['title'] }}</td>
							<td>Cretaed : {{ $post['created_at']->diffForHumans() }} <br> {{ $post['body'] }}</td>
							<td><img src="{{ asset('images') }}/{{ $post['post_image'] }}" width="100px" height="100px"></td>
							<td>
								<form action="{{ url('posts', ['id' => $post->id]) }}" method="post">
									<input type="hidden" name="_method" value="DELETE">
									{{ csrf_field() }}
		        					<a class="btn btn-primary" href="{{ url('posts') }}/{{ $post['id'] }}/edit">Edit</a>
				    				<button class="btn btn-danger">Delete</button>
								</form>
							</td>		
						</tr>
					@endforeach	
				@endif
			</table>
			<div class="col-md-12">{{ $posts->links() }}</div>
		</div>
	</div>
</div>
@endsection