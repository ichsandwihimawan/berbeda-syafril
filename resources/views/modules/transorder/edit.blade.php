<div class="ui inverted loading dimmer">
    <div class="ui text loader">Loading</div>
</div>
<div class="header">Ubah Data {{ $title or '' }}</div>
<div class="content">
    <form class="ui data form" id="dataForm" action="{{ url($pageUrl.$record->id) }}" method="POST">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $record->id }}">
         <div class="field">
            <label>Tipe</label>
            <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" placeholder="Tipe" name="tipe" value="{{ $record->tipe }}">
            </div>
        </div>
        <div class="field">
            <label>Nama Depan</label>
            <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" placeholder="Nama Depan" name="nama_depan" value="{{ $record->nama_depan }}" >
            </div>
        </div>
        <div class="field">
            <label>Nama Belakang</label>
            <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" placeholder="Nama Belakang" name="nama_belakang" value="{{ $record->nama_belakang }}" >
            </div>
        </div>
        <div class="field">
            <label>E-Mail</label>
            <div class="ui left icon input">
                <i class="mail icon"></i>
                <input type="email" placeholder="E-Mail" name="email" value="{{ $record->email }}" >
            </div>
        </div>
        <div class="field">
            <label>Kontak</label>
            <div class="ui left icon input">
                <i class="phone icon"></i>
                <input type="text" placeholder="kontak" name="kontak" value="{{ $record->kontak }}" >
            </div>
        </div>
        <div class="field">
            <label>Akun Induk</label>
            <select name="akun_induk_id" class="ui fluid dropdown">
                <option value="">Pilih Akun Induk</option>
                @foreach ($akun as $element)
                    <option value="{{ $element->id }}" {{ ($record->akun_induk_id == $element->id ? 'selected' : '') }}  >{{ $element->email." ( ".$element->order_count }} / 5 )</option>
                @endforeach
            </select>
        </div>
        @if (strpos($record->tipe, 'NETFLIX') !== false)
        <div class="field" id="profile">
            <label>Profile</label>
            <div class="ui left icon input">
                <i class="address card outline icon"></i>
                <input type="text" placeholder="profile" name="profile" value="{{ $record->profile }}">
            </div>
        </div>
        @endif
         <div class="field" id="pin">
            <label>Pin</label>
            <div class="ui left icon input">
                <i class="phone icon"></i>
                <input type="text" placeholder="Pin" name="pin" value="{{ $record->pin }}">
            </div>
         <div class="field" style="margin-top: 15px;">
            <label>Tgl Aktif</label>
            <div class="ui left icon input">
                <i class="calendar icon"></i>
                <input class="xxxxx" type="text" placeholder="Tgl Aktif" name="aktif_awal" id="tgl_awal" value="{{ $record->aktif_awal }}">
            </div>
        </div>
        <div class="field">
            <label>Paket</label>
            <div class="ui left icon input">
                <i class="file icon"></i>
                <input type="number" max="100" min="1" placeholder="Durasi" name="paket" value="{{ $record->paket }}">
            </div>
        </div>
        <div class="field" style="margin-bottom: 20px;">
            <label>Order By</label>
            <select name="order_id" class="ui fluid dropdown">
                {!! App\Models\Order::options('nama', 'id', ['selected' => $record->order_id], 'Pilih Order By') !!}
            </select>
        </div>
       
    </form>
</div>
<div class="actions">
    <div class="ui black deny button right">
        Batal
    </div>
    <div class="ui positive right labeled icon save button">
        Simpan
        <i class="checkmark icon"></i>
    </div>
</div>

<script>
 $(document).ready(function() {
       
         $('.xxxxx').datepicker({
            format: 'dd MM yyyy',
            autoclose : true
         });

                   $(document).on('click', '.button.save', function() {
  var selected_akun_induk = $('#akun_induk_id').val();
  $("select[name='filter[akun_induk_id]']").val();
});

   });
</script>


