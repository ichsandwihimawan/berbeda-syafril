<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">
	Tambah Akun 
</div>
<div class="content">
	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST" autocomplete="off">
		{!! csrf_field() !!}
		<div class="ui form">
			<div class="field">
				<label>Tipe</label>
				<input list="tipe" type="text" name="tipe" placeholder="Tipe">
				<datalist id="tipe">
					{!! App\Models\AkunInduk::options('tipe','tipe' ,['filters' => function ($q) { $q->groupBy('tipe'); } ]) !!}
				</datalist>
			</div>
		</div>
		<div class="ui form">
			<div class="field">
				<label>Email</label>
				<input type="text" name="email" placeholder="Email">
			</div>
		</div>
		<div class="ui form">
			<div class="field">
				<label>Password</label>
				<input type="text" name="password" placeholder="Password">
			</div>
		</div>
		<div class="field">
            <label>Tgl Aktif</label>
            <div class="ui left icon input">
                <i class="calendar icon"></i>
                <input class="xxxxx" type="text" placeholder="Tgl Aktif" name="aktif_awal" id="tgl_awal" value="{{ old('aktif_awal') }}">
            </div>
        </div>
        <div class="field">
            <label>Paket</label>
            <div class="ui left icon input">
                <i class="file icon"></i>
                <input type="number" max="100" min="1" placeholder="Paket" name="paket" value="{{ old('paket') }}">
            </div>
        </div>
        <div class="field">
            <label>Keterangan</label>	
            <div class="ui left icon input">
                <textarea name="keterangan"></textarea>
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

<script type="text/javascript">

   $(document).ready(function() {
       
         $('.xxxxx').datepicker({
            format: 'dd MM yyyy',
            autoclose : true
         });


   });
</script>