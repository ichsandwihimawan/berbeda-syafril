@extends('layouts.list')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/semanticui-calendar/calendar.min.css') }}">
@append

@section('js')
    <script src="{{ asset('plugins/semanticui-calendar/calendar.min.js') }}"></script>
@append

@section('filters')

<div class="field">
    <select name="filter[order_id]" placeholder="Order By" class="dropdown ui">
      {!! App\Models\Order::options('nama','id',[],'Pilih Order By') !!}
    </select>
  </div>

  <div class="field" id="email">
    <input name="filter[email]" id="email" placeholder="Email" type="email">
  </div>

  <div class="field">
    <select name="filter[tipe]" placeholder="Tipe" class="dropdown ui" id="tipe_grid">
      {!! App\Models\AkunInduk::options('tipe','tipe' ,['filters' => function ($q) { $q->groupBy('tipe'); } ], 'Pilih Tipe' ) !!}
    </select>
  </div>

  
  <div class="field">
    <select name="filter[akun_induk_id]" placeholder="Akun Induk" class="dropdown ui search selection" id="akun_induk_id_grid">
      {!! App\Models\AkunInduk::options('email','id',[],'Pilih Akun Induk') !!}
    </select>
  </div>
  <button type="button" class="ui teal icon filter button" data-content="Cari Data" style="margin-left: 2px">
    <i class="search icon"></i>
  </button>
  <button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian" style="margin-left: 2px">
    <i class="refresh icon"></i>
  </button>

    <button type="button" class="ui icon blue add button" data-content="Tambahkan Data" style="margin-left : 2px">
      <i class="plus icon"></i>
    </button>

   

@endsection

@section('js-filters')
  d.tipe = $("select[name='filter[tipe]']").val();
  d.email = $("input[name='filter[email]']").val();
  d.order_id = $("select[name='filter[order_id]']").val();
  d.akun_induk_id = $("select[name='filter[akun_induk_id]']").val();
@endsection

@section('rules')
  <script type="text/javascript">
    formRules = {
      tipe: 'empty',
      email: 'empty',
      order_id: 'empty',
      akun_induk_id: 'empty',
    };
  </script>
@endsection

@section('init-modal')
  <script>
    $(document).ready(function() {
      $(document).on('click', 'button.ui.blue.add' , function(event) {
        setTimeout(() => {
          const di = $("select[name='filter[tipe]']").val();  
          $('#tipe').val('').trigger('change');
          $('#tipe').val(di).trigger('change');
        }, 1000);
      })
      
      $(document).on('click', '.ui.detil.button', function(event) {
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




 

          $(document).on('change', '#tipe', function(event) {
            event.preventDefault();
            console.log(this.value);
            console.log(this.value.includes('NETFLIX'));
            if(this.value.includes('NETFLIX'))
            {
              $('#profile').show();

            }else{
              $('#profile').hide();

            }
            $.ajax({
              url: '{{ url('master/akun-induk/option') }}',
              type: 'GET',
              dataType: 'json',
              data: {tipe: this.value },
            })
            .done(function(s) {
                $('#akun_induk_id').empty().append(s.data);
                const lx = $("select[name='filter[akun_induk_id]']").val();  
                $('#akun_induk_id').val(lx).trigger('change');
              })
            .fail(function(e) {
              $('#akun_induk_id').empty();
            })
            .always(function() {
            });
          });
          

          




  $(document).on('change', 'tipe', function(event) {
            event.preventDefault();
            console.log(this.value);
            console.log(this.value.includes('SPOTIFY'));
            if(this.value.includes('SPOTIFY'))
            {
              // $('#profile').hide();
              // $("#dataForm input[name='email']").hide();
            }else{
              // $('#profile').show();
              // $("#dataForm input[name='email']").show();


            }
            $.ajax({
              url: '{{ url('master/akun-induk/option') }}',
              type: 'GET',
              dataType: 'json',
              data: {tipe: this.value },
            })
            .done(function(s) {
           
              })
            .fail(function(e) {
              $('#akun_induk_id').empty();
            })
            .always(function() {
            });
          });
          

 
          

          $(document).on('change', '#tipe_grid', function(event) {
              event.preventDefault();
              console.log(this.value);
              
              
              $.ajax({
                url: '{{ url('master/akun-induk/option') }}',
                type: 'GET',
                dataType: 'json',
                data: {tipe: this.value },
              })
              .done(function(s) {
                $('#akun_induk_id_grid').empty().append(s.data);
              })
              .fail(function(e) {
                $('#akun_induk_id_grid').empty();
              })
              .always(function() {
              });


          });



          $(document).on('change', '#akun_induk_id', function() {
            var value = $(this).val();
            var $opt = $('#akun_induk_id').find('option[value = '+value+']');

            if($opt.length) {
              var label = $opt.text();
              var m = label.match(/\(\d\/\d\)/);
              var count = m
                ? m[0].replace(/\(|\)/g).split('/')[0].match(/\d/)[0]
                : null;
              var next = parseInt(count) + 1;
              $('#profile input').val(next);
             
              var email = label.split(' ')[0];
              var tipe = $('#tipe').val();  
              if (tipe != "SPOTIFY" && tipe != "Youtube" && tipe != "SPOTIFY TRIAL") {
                  $("#dataForm input[name='email']").val(email);
                   var pret = parseInt(count) + 1111;

              $('#pin input').val(pret);
                  
              }
            
            }




              $(document).on('click', '.button.save', function() {
  var selected_akun_induk = $('#akun_induk_id').val();
  $("select[name='filter[akun_induk_id]']").val();
});
          });




          


          
    });
  </script>
@endsection

