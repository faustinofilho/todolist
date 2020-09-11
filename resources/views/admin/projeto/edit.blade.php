@extends('layouts.admin')
@section('content')

@if($projeto->user_id == \Auth::id())

<div class="col-lg-12">
	<!-- Dashboard Headline -->
	<div class="dashboard-headline">
		<h3>Project</h3>
		<span><strong style="color: red">{{ $projeto->titulo ?? '' }}</strong></span>
		<nav id="breadcrumbs" class="dark">
			<ul>
				<li><a href="#small-dialog" class="popup-with-zoom-anim buttons full-width button-sliding-icon">New Task <i class="icon-material-outline-arrow-right-alt"></i></a></li>
			</ul>
		</nav>

	</div>
</div>

<div class="col-lg-6">
   <div class="dashboard-box child-box-in-row">
      <div class="headline">
         <h3><i class="icon-material-outline-note-add"></i> Todo</h3>
      </div>
      <div class="dashboard-box-scrollbar" style="max-height: 626px" data-simplebar="init">
         <div class="simplebar-track vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="visibility: visible; top: 0px; height: 439px;"></div>
         </div>
         <div class="simplebar-track horizontal" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="visibility: visible; left: 0px; width: 25px;"></div>
         </div>
         <div class="simplebar-scroll-content" style="padding-right: 15px; margin-bottom: -30px;">
            <div class="simplebar-content" style="padding-bottom: 15px; margin-right: -15px;">
               <div class="content with-padding" id="todo">
					@foreach($todos as $todo)
						<div class="dashboard-note">
							<h3 id="titulo{{ $todo->id }}">{{ $todo->titulo ?? '' }}</h3>
							<p id="descricao{{ $todo->id }}">{!! $todo->descricao ?? '' !!}</p>
							<div class="note-footer">
								<span class="note-priority medium">Create - {{ $todo->created_at ?? '' }}</span>&nbsp;&nbsp;	
								<span class="note-priority high"><a href="#" data-tippy-placement="top" data-tippy="" onclick="concluirTarefa({{ $todo->id }})" style="color: #fff" data-original-title="Edit">Conclude</a></span>
								<div class="note-buttons">
								<a href="#" data-tippy-placement="top" data-tippy="" onclick="editTarefa({{ $todo->id }})" data-original-title="Edit"><i class="icon-feather-edit"></i></a>
								<a href="#" data-tippy-placement="top" data-tippy="" onclick="deleteTask({{ $todo->id }})" data-original-title="Remove"><i class="icon-feather-trash-2"></i></a>
								</div>
							</div>
						</div>
					@endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="col-lg-6">
   <div class="dashboard-box child-box-in-row">
      <div class="headline">
         <h3><i class="icon-material-outline-note-add"></i> Done</h3>
      </div>
      <div class="dashboard-box-scrollbar" style="max-height: 626px" data-simplebar="init">
         <div class="simplebar-track vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="visibility: visible; top: 0px; height: 439px;"></div>
         </div>
         <div class="simplebar-track horizontal" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="visibility: visible; left: 0px; width: 25px;"></div>
         </div>
         <div class="simplebar-scroll-content" style="padding-right: 15px; margin-bottom: -30px;">
            <div class="simplebar-content" style="padding-bottom: 15px; margin-right: -15px;">
               <div class="content with-padding" id="done">
					@foreach($dones as $done)

						<div class="dashboard-note">
							<h3 id="titulo{{ $done->id }}">{{ $done->titulo ?? '' }}</h3>
							<p id="descricao{{ $done->id }}">{!! $done->descricao ?? '' !!}</p>
							<div class="note-footer">
								<span class="note-priority medium">Create - {!! $todo->created_at ?? '' !!}</span>&nbsp;&nbsp;
								<span class="note-priority low">Conclusion - {!! $done->date_conclusion ?? '' !!}</span>
								<div class="note-buttons">
								</div>
							</div>
						</div>

					@endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

		<!-- Apply for a job popup
================================================== -->
<div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

<!--Tabs -->
<div class="sign-in-form">

	<ul class="popup-tabs-nav">
		<li><a href="#tab">Add Task</a></li>
	</ul>

	<div class="popup-tabs-container">

		<!-- Tab -->
		<div class="popup-tab-content" id="tab">
			<div class="notification error closeable" id="alertCampos" style="display: none">
				<p>Please fill in all the fields!</p>
				<a class="close"></a>
			</div>
			<form method="post"  name="form_project">
				<input type="hidden" name="projeto_id" value="{{ $projeto->id ?? '' }}">
				<input type="hidden" id="id" name="id">

				<input type="text" name="titulo" id="titulo"  placeholder="Title" title="Title">

				<textarea name="descricao" id="descricao" cols="10" placeholder="Description" class="with-border"></textarea>

				<!-- Button -->
				<button class="button full-width button-sliding-icon ripple-effect" id="enviaForm" type="button">submit <i class="icon-material-outline-arrow-right-alt"></i></button>
			</form>
		</div>

	</div>
</div>
</div>

@else
	<H1>you are not allowed to see this project!</H1>
@endif

@endsection

@section('scripts')
<script>

	function deleteTask(id)
	{
		if(confirm('Do you really want to delete that record?')){
				
			$.ajax(
			{
				url: "{{ url('/') }}/admin/tarefa/"+id,
				type: 'DELETE',
				success: function (response){					
					listTaskDone(response.done);
					listTaskTodo(response.todo);
				}
			});			
		}
	}

	function concluirTarefa(id)
	{
		if(confirm('Are you sure that this task is completed?')){				
			$.ajax(
			{
				url: "{{ url('/') }}/admin/tarefa/conclusion/"+id,
				type: 'GET',
				success: function (response){					
					listTaskDone(response.done);
					listTaskTodo(response.todo);
				}
			});			
		}
	}

	function editTarefa(id)
	{
		$('#id').val(id);
		$('#titulo').val($('#titulo'+id).text());
		$('#descricao').val($('#descricao'+id).text());
		$('.popup-with-zoom-anim').magnificPopup('open');
	}

	$('#enviaForm').on('click', function() {

		if($('#titulo').val() == '' || $('#descricao').val() == ''){
			$('#alertCampos').css('display', 'block');

			setTimeout( function() {
				$('#alertCampos').css('display', 'none');
			}, 3000 );
		} else {
			var formdata = new FormData($("form[name='form_project']")[0]);
			$.ajax({
				type: 'POST',
				url: "{{ route("admin.tarefa.store") }}",
				data: formdata ,
				processData: false,
				contentType: false,
				success: function (response) {

					$('#id').val('');
					$('#titulo').val('');
					$('#descricao').val('');

					listTaskDone(response.done);
					listTaskTodo(response.todo);
					$.magnificPopup.close();

				}
			});
		}

	});

	function listTaskDone(done)
	{
		$('#done').empty();
		var html = "";
		$.each(done, function(i, item)
		{			
			html +='<div class="dashboard-note">'
					+'<h3 id="titulo'+item.id+'">'+item.titulo+'</h3>'
					+'<p id="descricao'+item.id+'">'+item.descricao+'</p>'
					+'<div class="note-footer">'
					+'<span class="note-priority medium">Create - '+getTIMESTAMP(item.created_at)+'</span>&nbsp;&nbsp;'
					+'<span class="note-priority low">Conclusion -'+item.date_conclusion+'</span>'
					+'   <div class="note-buttons">'
					+'   </div>'
					+'</div>'
				+' </div>';
		});

		$('#done').append(html);
	}

	function listTaskTodo(todo)
	{
		$('#todo').empty();
		var html = "";
		$.each(todo, function(i, item)
		{
			html +='<div class="dashboard-note">'
					+'<h3 id="titulo'+item.id+'">'+item.titulo+'</h3>'
					+'<p id="descricao'+item.id+'">'+item.descricao+'</p>'
					+'<div class="note-footer">'
					+'<span class="note-priority medium">Create - '+getTIMESTAMP(item.created_at)+'</span>&nbsp;&nbsp;'
					+'			<span class="note-priority high"><a href="#" data-tippy-placement="top" data-tippy="" onclick="concluirTarefa('+item.id+')" style="color: #fff" data-original-title="Edit">Conclude</a></span>'
					+'   <div class="note-buttons">'
					+'      <a href="#" data-tippy-placement="top" data-tippy="" onclick="editTarefa('+item.id+')" data-original-title="Edit"><i class="icon-feather-edit"></i></a>'
					+'      <a href="#" data-tippy-placement="top" data-tippy="" onclick="deleteTask('+item.id+')" data-original-title="Remove"><i class="icon-feather-trash-2"></i></a>'
					+'   </div>'
					+'</div>'
				+' </div>';
		});

		$('#todo').append(html);
	}

	function Unix_timestamp(t)
	{
		var dt = new Date(t);
		var hr = dt.getHours();
		var m = "0" + dt.getMinutes();
		var s = "0" + dt.getSeconds();
		return hr+ ':' + m.substr(-2) + ':' + s.substr(-2);  
	}

	function getTIMESTAMP(t) 
	{
		date = new Date(t);
		year = date.getFullYear();
		month = date.getMonth()+1;
		dt = date.getDate();
		var hour = ("0" + (date.getHours() + 3 )).substr(-2);
		var minutes = ("0" + date.getMinutes()).substr(-2);
		var seconds = ("0" + date.getSeconds()).substr(-2);
		if (dt < 10) {
		dt = '0' + dt;
		}
		if (month < 10) {
		month = '0' + month;
		}
		return year+'-' + month + '-'+dt+ " " + hour + ":" + minutes + ":" + seconds;
	}

</script>
@endsection