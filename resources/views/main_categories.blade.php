@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-primary" onclick="scrape()">Scrape</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>id</th>
						<th>category_id</th>
						<th>parent_category</th>
						<th>category</th>
						<th>url</th>
						<th>no_of_sub_categories</th>
					</tr>
				</thead>
				<tbody>
					@foreach($table as $row)
					<tr>
						<td>{{$row->id}}</td>
						<td>{{$row->category_id}}</td>
						<td>{{$row->parent_category}}</td>
						<td>{{$row->category}}</td>
						<td>{{$row->url}}</td>
						<td>{{$row->no_of_sub_categories}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{$table->links()}}
		</div>
	</div>
</div>
<script>
	function scrape(){
		$.post("/scrape_main_categories",{"_token":"{{csrf_token()}}"}, function(data){

		});
	}
</script>
@endsection