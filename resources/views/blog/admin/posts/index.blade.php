@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-11">
			@if(session('success'))
         <div class="row justify-content">
            <div class="col-md-11">
               <div class="alert alert-success" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">x</span>
                  </button>
                  {{ session()->get('success')}}
               </div>
            </div>
         </div>
      @endif
			<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
				<a class="btn btn-primary" href="{{ route('blog.admin.posts.create')}}">Новая статья</a>
			</nav>
			<div class="card">
				<div class="card-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Автор</th>
								<th>Категория</th>
								<th>Заголовок</th>
								<th>Дата публикации</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($paginator as $post)
							@php
							/** App\Models\BlogPost $post */
							@endphp
							<tr @if(!$post->is_published) style="background-color:#E6E6FA;" @endif>
								<td>{{ $post->id }}</td>
								<td>{{ $post->user->name }}</td>
								<td>{{ $post->category->title }}</td>
								<td>
									<a href="{{ route('blog.admin.posts.edit', $post->id) }}">{{ $post->id }}</a>
								</td>
								<td>{{ $post->published_at ? Carbon\Carbon::parse($post->published_at)
									->format('d.M H:i') : '' }}
								</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot></tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
	@if ($paginator->total() > $paginator->count())
	<br>
	<div class="row justify-content-center">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					{{ $paginator->links() }}
				</div>
			</div>
		</div>
	</div>
	@endif
</div>

@endsection
