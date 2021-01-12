<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">
	Detil Akun
</div>
<div class="content">
	<form class="ui data form" id="dataForm" action="{{ url($pageUrl.$record->id) }}" method="POST" autocomplete="off">
		{!! csrf_field() !!}
	    <input type="hidden" name="_method" value="PUT">
	    <input type="hidden" name="id" value="{{ $record->id }}">
		<div class="ui form">
			<div class="field">
				<label>Tipe</label>
				<input list="tipe" type="text" name="tipe" placeholder="Tipe" value="{{ $record->tipe }}" readonly>
				<datalist id="tipe">
					{!! App\Models\AkunInduk::options('tipe','tipe' ,['filters' => function ($q) { $q->groupBy('tipe'); } ]) !!}
				</datalist>
			</div>
		</div>
		<div class="ui form">
			<div class="field">
				<label>Email</label>
				<input type="text" name="email" value="{{ $record->email or '' }}" placeholder="Email" readonly>
			</div>
		</div>
		<div class="ui form">
			<div class="field">
				<label>Password</label>
				<input type="text" name="password" placeholder="Password" value="{{ $record->password or '' }}" readonly>
			</div>
		</div>
		<div class="field">
            <label>Tgl Aktif</label>
            <div class="ui left icon input">
                <i class="calendar icon"></i>
                <input type="text" placeholder="Tgl Aktif" name="aktif_awal" id="tgl_awal" value="{{ $record->aktif_awal or '' }}" readonly>
            </div>
        </div>
        <div class="field">
            <label>Paket</label>	
            <div class="ui left icon input">
                <i class="file icon"></i>
                <input type="number" max="100" min="1" placeholder="Paket" name="paket" value="{{ $record->paket or '' }}"readonly>
            </div>
        </div>
        <div class="field">
            <label>Keterangan</label>	
            <div class="ui left icon input">
                <textarea>{{$record->keterangan}}</textarea>
            </div>
        </div>
	</form>
</div>
<div class="actions">
	<div class="ui black deny button">
		Batal
	</div>
</div>