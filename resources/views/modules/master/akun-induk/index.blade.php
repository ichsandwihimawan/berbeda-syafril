@extends('layouts.list')

@section('js-filters')
    d.tipe = $("select[name='filter[tipe]']").val();
    d.email = $("input[name='filter[email]']").val();
@endsection

@section('rules')
	<script type="text/javascript">
		formRules = {
			nama: ['empty'],
		};
	</script>
@endsection

@section('filters')
	<div class="field">
		<select name="filter[tipe]" placeholder="Tipe" class="dropdown ui">
			{!! App\Models\AkunInduk::options('tipe','tipe' ,['filters' => function ($q) { $q->groupBy('tipe'); } ]) !!}
		</select>
	</div>
	<div class="field">
		<input name="filter[email]" placeholder="Email" type="text">
	</div>
	<button type="button" class="ui teal icon filter button" data-content="Cari Data">
		<i class="search icon"></i>
	</button>
	<button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian">
		<i class="refresh icon"></i>
	</button>
@endsection

@section('toolbars')
	{{-- @if(auth()->user()->canPerm('master-kelola')) --}}
		<button type="button" class="ui blue add button">
			<i class="plus icon"></i>
			Tambah Data
		</button>
	{{-- @endif --}}
@endsection


@section('init-modal')
	<script>

		$(document).on('click', 'button.ui.red.add', function(event) {
               event.preventDefault();

              var id = $(this).data('id');
              // /* Act on the event */
              loadModal({
                  'url' : '{{ url($pageUrl) }}/'+id,
                  'modal' : '.{{ $modalSize }}.modal',
                  'formId' : '#jamanBatu',
                  'onShow' : function(){ 
                      onShow();
                  },
              })
          });


		$(document).ready(function() {
			$(document).on('click', '.detil', function(event) {
	            event.preventDefault();
	            var id = $(this).data('id');
	            // /* Act on the event */
	            loadModal({
	                'url' : '{{ url($pageUrl) }}/'+id,
	                'modal' : '.{{ $modalSize }}.modal',
	                'formId' : '#dataForm',
	                'onShow' : function(){ 
	                    onShow();
	                },
	            })
	        });
		});

		$(document).on('click', '.ui.perpanjang.button', function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            // /* Act on the event */
            loadModal({
                'url' : '{{ url($pageUrl) }}/perpanjang/'+id,
                'modal' : '.mini.modal',
                'formId' : '#dataForm',
                'onShow' : function(){ 
                    onShow();
                },
            })
        });

		$(document).on('click', '.ui.copy.button', function(event) {
	            event.preventDefault();
	            var id = $(this).data('id');
	            // /* Act on the event */
	            loadModal({
	                'url' : '{{ url($pageUrl) }}/copy/'+id,
	                'modal' : '.{{ $modalSize }}.modal',
	                'formId' : '#dataForm',
	                'onShow' : function(){ 
	                    onShow();
	                },
	            })
	        });
	</script>
@endsection