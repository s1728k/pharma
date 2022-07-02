@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr>
					<td><select id="cat">
						@foreach($category as $category)
						<option>{{$category->name}}</option>
						@endforeach
					</select></td>
					<td><select id="prod">
						<option>fsfsfs</option>
					</select></td>
					<td><input type="text" name="search" /></td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script>
	var cat = "{!! $category !!}";
	var prod = "{!! $products !!}";

	var htm = "<option>$val</option>";
	var cat_html;
	for(var i=0; i<cat.length; i++){
		cat_html = cat_html + htm.replace("$val", cat[i].name);
	}
	$("#cat").html(cat_html);
</script>
@endsection
