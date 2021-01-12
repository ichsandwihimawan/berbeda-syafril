<div class="ui inverted loading dimmer">
    <div class="ui text loader">Loading</div>
</div>
<div class="header">Copy Data {{ $title or '' }}</div>
<div class="content">
    <form class="ui form">
    <textarea id="kopi" placeholder="Tell us more" rows="7">
{{$record->email}}
{{$record->password}}
</textarea>
</form>
</div>
<div class="actions">
    <div class="ui black deny button">
        Batal
    </div>
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