<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">
	Tambah Order
</div>
<div class="content">
	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST" autocomplete="off">
		{!! csrf_field() !!}
		<div class="ui form">
			<div class="field">
				<label>Order</label>
				<input type="text" name="nama" placeholder="Nama Order">
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
