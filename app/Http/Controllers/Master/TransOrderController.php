<?php

namespace App\Http\Controllers\Master;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Validation */
use App\Http\Requests\TransOrderRequest;

/* Models */
use App\Models\TransOrder;
use App\Models\AkunInduk;

/* Libraries */
use DataTables;
use Entrust;
use Carbon\Carbon;
use Hash;

class TransOrderController extends Controller
{
    protected $link = 'master/transorder/';
    protected $perms = 'master-transorder';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setPerms($this->perms);
        $this->setTitle("Transaksi");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Master' => '#', 'Transaksi' => '#']);

        // Header Grid Datatable
        $this->setTableStruct([
            [
                'data' => 'num',
                'name' => 'num',
                'label' => '#',
                'orderable' => false,
                'searchable' => false,
                'className' => "center aligned",
                'width' => '40px',
            ],
            /* --------------------------- */
            [
                'data' => 'tipe' ,
                'name' => 'tipe',
                'label' => 'Tipe',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'nama_depan',
                'name' => 'nama_depan',
                'label' => 'Nama Lengkap',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'profile',
                'name' => 'profile',
                'label' => 'Profile',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
              [
                'data' => 'pin',
                'name' => 'pin',
                'label' => 'Pin',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'email',
                'name' => 'email',
                'label' => 'Email',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'kontak',
                'name' => 'kontak',
                'label' => 'No Kontak',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'order_id',
                'name' => 'order_id',
                'label' => 'Order By',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'akun_induk_id',
                'name' => 'akun_induk_id',
                'label' => 'Akun Induk',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'aktif_awal',
                'name' => 'aktif_awal',
                'label' => 'Tgl Aktif',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'paket',
                'name' => 'paket',
                'label' => 'Paket',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'aktif_akhir',
                'name' => 'aktif_akhir',
                'label' => 'Tgl Expire',
                'className' => "center aligned",
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'label' => 'Dibuat Pada',
                'searchable' => false,
                'className' => "center aligned",
                'sortable' => true,
            ],
            [
                'data' => 'action',
                'name' => 'action',
                'label' => 'Aksi',
                'searchable' => false,
                'sortable' => false,
                'className' => "center aligned",
                'width' => '150px',
            ]
        ]);

        \DB::listen(function($q) {
    \Log::info($q->sql, $q->bindings);
});
    }

    public function grid(Request $request)
    {
        $records = TransOrder::select('*');
        
        //Init Sort
        if (!isset(request()->order[0]['column'])) {
            $records->orderBy('created_at', 'desc');
        }

        //Filters
        if ($tipe = $request->tipe) {
            $records->where('tipe', $tipe);
        }

        if ($email = $request->email) {
            $records->where('email', 'like', '%' . $email . '%');
        }

        if ($order_id = $request->order_id) {
            $records->where('order_id', $order_id);
        }

        if ($tipe = $request->tipe) {
            $records->where('tipe', $tipe);
        }


        if ($akun_induk_id = $request->akun_induk_id) {
            $records->where('akun_induk_id', $akun_induk_id);
        }

        $link = $this->link;
        return DataTables::of($records)

 

            ->addColumn('num', function ($record) use ($request) {
                return $request->get('start');
            })
            ->editColumn('fullname', function ($record) {
                return $record->fullName;
            })
            ->editColumn('paket', function ($record) {
                return $record->paket." Bulan";
            })

             ->editColumn('pin', function ($record) {
                return $record->pin;
            })
            
            ->editColumn('akun_induk_id', function ($record) {
                return $record->akunInduk->email;
            })
            ->editColumn('order_id', function ($record) {
                return $record->order->nama;
            })
            ->editColumn('order_by', function ($record) {
                return $record->orderLabel();
            })
            ->editColumn('akun_induk_id', function ($record) {
                return $record->akunInduk->email;
            })
            ->editColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            }) 
            ->addColumn('action', function ($record) use ($link){
                $btn = '';

                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'datas' => [
                        'id' => $record->id
                    ],
                    // 'disabled' => isset($this->perms) && $this->perms != '' && !Entrust::can($this->perms.'-show'),
                    'tooltip' => 'Perpanjang Data',
                    'id'   => $record->id,
                    'class' => 'ui icon detil button'
                ]);
                
                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'datas' => [
                        'id' => $record->id
                    ],
                    'disabled' => isset($this->perms) && $this->perms != '' && !Entrust::can($this->perms.'-edit'),
                    'id'   => $record->id
                ]);
                // Delete
                $btn .= $this->makeButton([
                    'type' => 'delete',
                    'id'   => $record->id,
                    'url'   => url($link.$record->id)
                ]);

                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'label' => '<i class="envelope icon"></i>',
                    'tooltip' => 'Copy',
                    'id'   => $record->id,
                    'class' => 'yellow icon copy',
                ]);


                return $btn;
            })
            ->rawColumns(['order_by', 'action'])
            ->make(true);
    }

    public function index()
    {
        return $this->render('modules.transorder.index', ['mockup' => false]);
    }

    public function copy($id)
    {
        $record = TransOrder::find($id);
        $akun = AkunInduk::withCount(['order'])
            ->orderBy('order_count', 'ASC')
            ->get();
        return $this->render('modules.transorder.copy', [
            'record' => $record,
            'akun' => $akun
        ]);
    }

    public function show($id)
    {
        $record = TransOrder::find($id);
        $akun = AkunInduk::withCount(['order'])
            ->orderBy('order_count', 'ASC')
            ->get();
        return $this->render('modules.transorder.detail', [
            'record' => $record,
            'akun' => $akun
        ]);
    }

    public function create(Request $request)
    {   
        $record = AkunInduk::withCount(['order'])
        ->orderBy('order_count', 'ASC')
        ->get();

        $record->a = $request->a;
        $record->b = $request->b;
        return $this->render('modules.transorder.create', compact('record' ));
    }

    public function store(TransOrderRequest $request)
    {
        $row = $request->all();
        $record = new TransOrder;
        $row['aktif_awal'] = Carbon::createFromFormat('d F Y',$request->aktif_awal)->format('Y-m-d');

        $row['aktif_akhir'] = Carbon::parse($row['aktif_awal'])->addMonths($request->paket)->format('Y-m-d');
        $record->fill($row);

        // $c = new \Carbon\Carbon($record->aktif_awal);
        // $record->aktif_akhir = $c->addMonth($record->paket);

        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function edit($id)
    {
        $record = TransOrder::find($id);
        $akun = AkunInduk::where('tipe', $record->tipe)->withCount(['order'])
        ->orderBy('order_count', 'ASC')
        ->get();

        return $this->render('modules.transorder.edit', [
            'record' => $record,
            'akun' => $akun
        ]);
     }

    public function update(TransOrderRequest $request, $id)
    {
        $row = $request->all();
        $record = TransOrder::find($id);
        $row['aktif_awal'] = Carbon::createFromFormat('d F Y',$request->aktif_awal)->format('Y-m-d');

        $row['aktif_akhir'] = Carbon::parse($row['aktif_awal'])->addMonths($request->paket)->format('Y-m-d');
        $record->fill($row);
        
        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function destroy($id)
    {
        $record = TransOrder::find($id);
        $record->delete();
        
        

        return response([
            'status' => true,
        ]);
    }


    

    

    
}
