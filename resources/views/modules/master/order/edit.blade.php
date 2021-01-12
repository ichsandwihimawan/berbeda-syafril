<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">
	Ubah Order
</div>
<div class="content">
	<form class="ui data form" id="dataForm" action="{{ url($pageUrl.$record->id) }}" method="POST" autocomplete="off">
		{!! csrf_field() !!}
	    <input type="hidden" name="_method" value="PUT">
	    <input type="hidden" name="id" value="{{ $record->id }}">
	    
		<div class="ui form">
			<div class="field">
				<label>Order</label>
				<input type="text" name="nama" placeholder="Nama unit" value="{{ $record->nama or '' }}">
			</div>
		</div>
	</form>
</div>
<div class="actions">
	<div class="ui black deny button">
		Batal
	</div>
	<div class="ui positive right labeled icon save button">
		Simpan
		<i class="save icon"></i>
	</div>
</div>
