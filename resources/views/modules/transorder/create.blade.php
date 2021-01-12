<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Buat Data {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl) }}" method="POST" autocomplete="off">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
        <div class="ui form">
            <div class="field">
                <label>Tipe</label>
                <select type="text" name="tipe" placeholder="Tipe" id="tipe" class="ui dropdown">
                    {!! App\Models\AkunInduk::options('tipe','tipe' ,['filters' => function ($q) { $q->groupBy('tipe'); } , 'selected' => $record->a]) !!}
                </select>
            </div>
        </div>
        <div class="field">
        	<label>Nama Depan</label>
            <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" placeholder="Nama Depan" name="nama_depan" value="{{ old('nama_depan') }}">
            </div>
        </div>
        <div class="field">
            <label>Nama Belakang</label>
            <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" placeholder="Nama Belakang" name="nama_belakang" value="{{ old('nama_depan') }}">
            </div>
        </div>
        <div class="field">
        	<label>E-Mail</label>
            <div class="ui left icon input">
                <i class="mail icon"></i>
                <input type="email" class="email" placeholder="E-Mail" name="email" value="{{ old('email')  }}">
            </div>
        </div>
        <div class="field">
            <label>Kontak</label>
            <div class="ui left icon input">
                <i class="phone icon"></i>
                <input type="text" placeholder="kontak" name="kontak" value="{{ old('kontak') }}">
            </div>
        </div>
        <div class="field">
            <label>Akun Induk</label>
            <select name="akun_induk_id" class="ui fluid dropdown" id="akun_induk_id">
                <option value="">Pilih Akun Induk</option>
               {{--  @foreach ($record as $element)
                    <option value="{{ $element->id }}">{{ $element->email." ( ".$element->order_count }} / 5 )</option>
                @endforeach --}}
            </select>
        </div>
        <div class="field" id="profile" style="display:none;">
            <label>Profile</label>
            <div class="ui left icon input">
                <i class="address card outline icon"></i>
                <input type="text" placeholder="profile" name="profile" value="{{ old('profile') }}">
            </div>
        </div>


        
            <div class="field" id="pin">
            <label>Pin</label>
            <div class="ui left icon input">
                <i class="phone icon"></i>
                <input type="text" placeholder="Pin" name="pin" value="{{ old('pin') }}">
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
                <input type="number" max="100" min="1" placeholder="Durasi" name="paket" value="{{ old('email') }}">
            </div>
        </div>
        <div class="field">
            <label>Order By</label>
            <select name="order_id" class="ui fluid dropdown">
                {!! App\Models\Order::options('nama', 'id', [], 'Pilih Order By') !!}
            </select>
        </div>
       
	</form>
</div>
<div class="actions">
	<div class="ui black deny button">
		Batal
	</div>
	<div class="ui positive right labeled icon save button">
		Simpan
		<i class="checkmark icon"></i>
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