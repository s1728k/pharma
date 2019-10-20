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
						<th>drug_code</th>
						<th>parent_category</th>
						<th>category_id</th>
						<th>sub_category_id</th>
						<th>drug</th>
						<th>composition</th>
						<th>form_of_drug</th>
						<th>manufacturer</th>
						<th>pack_size</th>
						<th>mrp</th>
						<th>url</th>
					</tr>
				</thead>
				<tbody>
					@foreach($table as $row)
					<tr>
						<td>{{$row->id}}</td>
						<td>{{$row->drug_code}}</td>
						<td>{{$row->parent_category}}</td>
						<td>{{$row->category_id}}</td>
						<td>{{$row->sub_category_id}}</td>
						<td>{{$row->drug}}</td>
						<td>{{$row->composition}}</td>
						<td>{{$row->form_of_drug}}</td>
						<td>{{$row->manufacturer}}</td>
						<td>{{$row->pack_size}}</td>
						<td>{{$row->mrp}}</td>
						<td>{{$row->url}}</td>
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
		$.post("/scrape_drugs_list",{"_token":"{{csrf_token()}}"}, function(data){

		});
	}
</script>
@endsection