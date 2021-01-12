@php


$text = '';
$text1 = 
"$record->nama Terimakasih telah berlangganan ".$record->tipe." Premium di kami,


Tanggal aktif : ".$record->aktif_awal."
Email : ".$record->email."
Paket : ".$record->paket." Bulan 
Tanggal Expire : ".$record->aktif_akhir ;

$text2 = 
"Terimakasih telah berlangganan ".$record->tipe." Premium di kami,

Tanggal aktif : ".$record->aktif_awal."
Email : ".$record->akunInduk->email."
Password : ".$record->akunInduk->password."
Paket : ".$record->paket." Bulan 
Profile : ".$record->profile." 
Jika Diminta memasukkan PIN : ".$record->pin." 

Tanggal Expire : ".$record->aktif_akhir;

if (strpos($record->tipe, 'NETFLIX') === 0)
{
    $text = $text2;
}else{
    $text = $text1;
}

@endphp
<div class="ui inverted loading dimmer">
    <div class="ui text loader">Loading</div>
</div>
<div class="header">Copy Data {{ $title or '' }}</div>
<div class="content">
    <form class="ui form"><textarea id="kopi" placeholder="Tell us more" rows="7">{{$text}}</textarea></form>
</div>
<div class="actions">
    <div class="ui black deny button">
        Batal
    </div>
    <a class="ui green deny button" href="https://wa.me/{{ str_replace("-",null, $record->kontak ) }}?text={{urlencode($text)}}" target="_blank">
        <i class="phone square icon"></i>
        Whatsapp
    </a>
    <div class="ui right labeled icon button deny teal" onclick="kopi()">
        Copy
        <i class="copy icon"></i>
    </div>
</div>
<script type="text/javascript">

   function kopi(){
        var copyText = $('#kopi');
        copyText.select();
        document.execCommand("copy");
   };

</script>