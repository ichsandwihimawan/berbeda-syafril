<?php

namespace App\Http\Controllers\Master;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Validation */
use App\Http\Requests\AkunIndukRequest;

/* Models */
use App\Models\AkunInduk;

/* Libraries */
use DataTables;
use Entrust;
use Carbon;
use Hash;

class AkunIndukController extends Controller
{
    protected $link = 'master/akun-induk/';
    protected $perms = 'master-akun-induk';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setPerms($this->perms);
        $this->setTitle("Akun Induk");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Master' => '#', 'Akun Induk' => '#']);

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
                'data' => 'tipe',
                'name' => 'tipe',
                'label' => 'Tipe',
                'searchable' => true,
                'sortable' => true,
            ],
            [
                'data' => 'email',
                'name' => 'email',
                'label' => 'Email',
                'searchable' => true,
                'sortable' => true,
            ],
            [
                'data' => 'password',
                'name' => 'password',
                'label' => 'Password',
                'searchable' => true,
                'sortable' => true,
            ],
            [
                'data' => 'aktif_awal',
                'name' => 'aktif_awal',
                'label' => 'Aktif Awal',
                'searchable' => false,
                'sortable' => true,
                'className' => "center aligned",
            ],
            [
                'data' => 'paket',
                'name' => 'paket',
                'label' => 'Paket',
                'searchable' => false,
                'sortable' => true,
                'className' => "center aligned",
            ],
            [
                'data' => 'keterangan',
                'name' => 'keterangan',
                'label' => 'Keterangan',
                'searchable' => false,
                'sortable' => true,
                'className' => "center aligned",
            ],
            [
                'data' => 'aktif_akhir',
                'name' => 'aktif_akhir',
                'label' => 'Aktif Akhir',
                'searchable' => false,
                'sortable' => true,
                'className' => "center aligned",
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'label' => 'Dibuat Pada',
                'searchable' => false,
                'sortable' => true,
                'className' => "center aligned",
            ],
            [
                'data' => 'action',
                'name' => 'action',
                'label' => 'Aksi',
                'searchable' => false,
                'sortable' => false,
                'className' => "center aligned",
                'width' => '200px',
            ]
        ]);
    }

    public function grid(Request $request)
    {
        $records = AkunInduk::select('*');
        
        //Init Sort
        if (!isset(request()->order[0]['column'])) {
            $records->orderBy('created_at', 'desc');
        }

        //Filters
        if ($email = $request->email) {
            $records->where('email', 'like', '%' . $email . '%');
        }

        if ($tipe = $request->tipe) {
            $records->where('tipe', $tipe);
        }

        $link = $this->link;
        return DataTables::of($records)
            ->addColumn('num', function ($record) use ($request) {
                return $request->get('start');
            })
            ->editColumn('keterangan', function ($record) {
                return $record->readMoreText('keterangan', 15);
            }) 
            ->editColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            }) 
            ->editColumn('paket', function ($record) {
                return $record->paket." Bulan";
            })
            ->addColumn('action', function ($record) use ($link){
                $btn = '';

                $btn .= $this->makeButton([
                    // 'disabled' => isset($this->perms) && $this->perms != '' && !Entrust::can($this->perms.'-show'),
                    'type' => 'modal',
                    'datas' => [
                        'id' => $record->id
                    ],
                    'tooltip' => 'Perpanjang Data',
                    'class' => 'ui perpanjang icon button'
                ]);
                
                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'datas' => [
                        'id' => $record->id
                    ],
                    'disabled' => isset($this->perms) && $this->perms != '' && !Entrust::can($this->perms.'-edit'),
                    'id'   => $record->id
                ]);

                $btn .= $this->makeButton([
                    'type' => 'modal',
                    'tooltip' => 'Detil',
                    'class' => 'teal icon detil',
                    'label' => '<i class="eye icon"></i>',
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
                    'label' => '<i class="copy icon"></i>',
                    'tooltip' => 'Copy',
                    'id'   => $record->id,
                    'class' => 'yellow icon copy',
                ]);

                return $btn;
            })
            ->rawColumns(['order_by', 'action', 'keterangan'])
            ->make(true);
    }

    public function index()
    {
        return $this->render('modules.master.akun-induk.index', ['mockup' => false]);
    }

    public function copy($id)
    {
        $record = AkunInduk::find($id);

        return $this->render('modules.master.akun-induk.copy', [
            'record' => $record
        ]);
    }

    public function show($id)
    {
        $record = AkunInduk::find($id);

        return $this->render('modules.master.akun-induk.show', [
            'record' => $record
        ]);
    }


    public function create()
    {
        return $this->render('modules.master.akun-induk.create');
    }

    public function store(AkunIndukRequest $request)
    {
        $request['aktif_akhir'] = Carbon::parse($request->aktif_awal)->addMonths($request->paket)->format('d F Y');
        $record = new AkunInduk;
        $record->fill($request->all());
        $record->save();


        return response([
            'status' => true
        ]);
    }

    public function edit($id)
    {
        $record = AkunInduk::find($id);

        return $this->render('modules.master.akun-induk.edit', [
            'record' => $record
        ]);
    }

    public function perpanjang($id)
    {
        $record = AkunInduk::find($id);

        return $this->render('modules.master.akun-induk.perpanjang', [
            'record' => $record
        ]);
    }

    public function update(AkunIndukRequest $request, $id)
    {
        $request['aktif_akhir'] = Carbon::parse($request->aktif_awal)->addMonths($request->paket)->format('d F Y');
        $record = AkunInduk::find($id);
        $record->fill($request->all());
        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function destroy($id)
    {
        $record = AkunInduk::find($id);
        $record->delete();

        return response([
            'status' => true,
        ]);
    }

    public function option(Request $request)
    {
        $akun = AkunInduk::where('tipe',$request->tipe)->withCount(['order'])
            ->orderBy('order_count', 'ASC')
            ->get();

        $data = $akun->map(function($v, $i){
            return '<option value="'.$v->id.'">'.$v->email.' ('.$v->order_count.'/5)</option>';
        });

        // $data->prepend('<option>Pilih Akun Induk</option>');

        return response([
            'status' => true,
            'data' => $data
        ]);
    }
}
