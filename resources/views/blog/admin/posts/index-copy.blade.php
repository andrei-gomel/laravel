@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-md-12">
			<nav class="navbar bg-white">
				<a class="btn btn-primary" href="{{route('blog.admin.categories.create')}}">Добавить</a>
			</nav>
			<div class="card-body bg-white">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Категория</th>
							<th>Родитель</th>
						</tr>
					</thead>
					<tbody>
					@foreach($paginator as $item)
						
						<tr>
							<td>{{$item->id}}</td>
							<td>
								<a href="{{route('blog.admin.categories.edit', $item -> id)}}">
									{{$item->title}}
								</a>
							</td>
							<td>{{$item -> parent_id}}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		
		@if($paginator->total() > $paginator->count())
		
			<div class="col-md-12">
				<div class="card-body bg-white">
				{{$paginator->links()}}
				</div>
			</div>
		
		@endif
	</div>
@endsection