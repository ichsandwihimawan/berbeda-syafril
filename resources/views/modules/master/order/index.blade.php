@extends('layouts.list')

@section('js-filters')
    d.nama = $("input[name='filter[nama]']").val();
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
		<input name="filter[nama]" placeholder="Nama Unit" type="text">
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
		<button type="button" class="ui blue add pin button">
			<i class="plus icon"></i>
			Tambah Data
		</button>
	{{-- @endif --}}
@endsection