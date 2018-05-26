@extends('layouts.app')

@section('title','Blog')

@section('content')
	<!--body-->
	<div class="container-fluid text-center">
		<h1>Kopigenik Blog</h1>
		<h3>All you need to know about coffee is here</h3>

		<div class="row">
			@foreach($posts as $post)
					<a href="/blog/{{$post->id}}" class="link-text">
						<div class="col-sm-4">
							<div class="shadow">
								<img class="img-responsive center-block slideanim" src="{{secure_asset('asset/original/rsz_blog_espresso.jpg')}}" alt="espresso extraction">				
								<div style="padding: 20px;">					
									<p style="color: grey;">{{Carbon\Carbon::parse($post->created_at)->format('j F Y')}}</p>
									<p style="font-size: 24px; color: #000;">{{$post->title}}</p>
								</div>
							</div>		
						</div>
					</a>									
			@endforeach			
		</div>
	</div>
@endsection