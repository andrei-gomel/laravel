@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-12">
			<nav class="navbar">
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
						
						<tr @if (in_array($item->parent_id, [0,1])) style="background-color:#E6E6FA;"@endif>
							<td>{{$item->id}}</td>
							<td>
								<a href="{{route('blog.admin.categories.edit', $item->id)}}">
									{{$item->title}}
								</a>
							</td>
							<td>
								{{--{{$item->parentCategory->title ?? 'Корень'}}--}}
								{{--{{$item->parent_id}}--}}
								{{$item->parentTitle}}
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		
		@if($paginator->total() > $paginator->count())
		
			<div class="col-sm-12">
				<div class="card-body bg-white">
				{{$paginator->links()}}
				</div>
			</div>
		
		@endif
	</div>
@endsection