@extends('layouts.admin')
@section('content')

			
<div class="col-lg-12">
	<!-- Dashboard Headline -->
	<div class="dashboard-headline">
		<h3>Projects</h3>
		<span>List</span>

		<nav id="breadcrumbs" class="dark">
			<ul>
				<li><a href="#small-dialog" class="popup-with-zoom-anim buttons full-width button-sliding-icon">Create Project <i class="icon-material-outline-arrow-right-alt"></i></a></li>
			</ul>
		</nav>
	</div>
</div>



<div id="projetos" class="row">

	@foreach($projetos as $projeto)

		<div class="fun-fact" data-fun-fact-color="#36bd78">
			<div class="fun-fact-text">
				<span id="titulo{{ $projeto->id }}">{{ $projeto->titulo ?? '' }}</span>
			</div>
			<a class="button ripple-effect" href="#small-dialog" onclick="editProjeto({{ $projeto->id }}, '{{ $projeto->titulo }}')"><span class="icon-feather-edit" style="color: #fff"></span></a>
			&nbsp;
			<a href="/admin/projeto/{{ $projeto->id }}/edit" class="button dark ripple-effect"><span class="icon-feather-eye" style="color: #fff"></span></a>
			&nbsp;
			<a href="#" class="button gray ripple-effect-dark" onclick="deleteProjeto({{ $projeto->id }})"><span class="icon-feather-trash" style="color: red"></span></a>
		</div>
		
	@endforeach

</div>


<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
	<!--Tabs -->
	<div class="sign-in-form">

		<ul class="popup-tabs-nav">
			<li><a href="#tab">Project name</a></li>
		</ul>
		
		<div class="popup-tabs-containesr">

			<!-- Tab -->
			<div class="popup-tab-content" id="tab">
				<div class="notification error closeable" id="alertCampos" style="display: none">
					<p>Please fill in all the fields!</p>
					<a class="close"></a>
				</div>
				<form method="post"  name="form_project">
				
					<input type="hidden" id="id" name="id">

					<div class="section-headline margin-top-25 margin-bottom-12">
						<h5>Project name</h5>
					</div>
					<input type="text" name="titulo" id="titulo" class="with-border">

					<!-- Button -->
					<button class="button full-width button-sliding-icon ripple-effect" id="enviaForm" type="button">submit <i class="icon-material-outline-arrow-right-alt"></i></button>
				</form>
			</div>

		</div>
	</div>
</div>

@endsection

@section('scripts')
<script>

	function editProjeto(id)
	{
		$('#id').val(id);
		$('#titulo').val($('#titulo'+id).text());

		$('.popup-with-zoom-anim').magnificPopup('open');

	}

	function deleteProjeto(id)
	{
		if(confirm('Do you really want to delete that record?')){
				
			$.ajax(
			{
				url: "{{ url('/') }}/admin/projeto/"+id,
				type: 'DELETE',
				success: function (response){
					listPorject(response.projetos);
				}
			});			
		}
	}

	$('#enviaForm').on('click', function() {

		if($('#titulo').val() == ''){
			$('#alertCampos').css('display', 'block');

			setTimeout( function() {
				$('#alertCampos').css('display', 'none');
			}, 3000 );
			
		} else {

			var formdata = new FormData($("form[name='form_project']")[0]);

				$.ajax({
					type: 'POST',
					url: "{{ route("admin.projeto.store") }}",
					data: formdata ,
					processData: false,
					contentType: false,
					success: function (response) {

						$.magnificPopup.close();

						$('#id').val('');
						$('#titulo').val('');

						listPorject(response.projetos);

					}
				});
		}
	});

	function listPorject(projetos)
	{

		$('#projetos').empty();
		var html = "";
		$.each(projetos, function(i, item)
		{
			html +='<div class="fun-fact" data-fun-fact-color="#36bd78" id="row'+i+'">'
						+'<div class="fun-fact-text">'
							+'<span id="titulo'+item.id+'">'+item.titulo+'</span>'
						+'</div>'
						+'<a href="#small-dialog" class="button ripple-effect" onclick="editProjeto('+item.id+')"><span class="icon-feather-edit" style="color: #fff"></span></a>'
						+'&nbsp;'
						+'<a href="/admin/projeto/'+item.id+'/edit" class="button dark ripple-effect"><span class="icon-feather-eye" style="color: #fff"></span></a>'
						+'&nbsp;'
						+'<a href="#" class="button gray ripple-effect-dark" onclick="deleteProjeto('+item.id+')"><span class="icon-feather-trash" style="color: red"></span></a>'
					+'</div>';
		});

		$('#projetos').append(html);
	}

</script>
@endsection