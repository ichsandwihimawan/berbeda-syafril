<?php

namespace App\Http\Controllers\Master;

/* Base App */
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Validation */
use App\Http\Requests\OrderRequest;

/* Models */
use App\Models\Order;

/* Libraries */
use DataTables;
use Entrust;
use Carbon;
use Hash;

class OrderController extends Controller
{
    protected $link = 'master/order/';
    protected $perms = 'master-order';

    function __construct()
    {
        $this->setLink($this->link);
        $this->setPerms($this->perms);
        $this->setTitle("Order");
        $this->setModalSize("mini");
        $this->setBreadcrumb(['Master' => '#', 'Order' => '#']);

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
                'data' => 'nama',
                'name' => 'nama',
                'label' => 'Nama',
                'searchable' => false,
                'sortable' => true,
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'label' => 'Dibuat Pada',
                'searchable' => false,
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
    }

    public function grid(Request $request)
    {
        $records = Order::select('*');
        
        //Init Sort
        if (!isset(request()->order[0]['column'])) {
            $records->orderBy('created_at', 'desc');
        }

        //Filters
        if ($email = $request->email) {
            $records->where('email', 'like', '%' . $email . '%');
        }

        $link = $this->link;
        return DataTables::of($records)
            ->addColumn('num', function ($record) use ($request) {
                return $request->get('start');
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
                    'disabled' => isset($this->perms) && $this->perms != '' && !Entrust::can($this->perms.'-edit'),
                    'id'   => $record->id
                ]);
                // Delete
                $btn .= $this->makeButton([
                    'type' => 'delete',
                    'id'   => $record->id,
                    'url'   => url($link.$record->id)
                ]);

                return $btn;
            })
            ->rawColumns(['order_by', 'action'])
            ->make(true);
    }

    public function index()
    {
        return $this->render('modules.master.order.index', ['mockup' => false]);
    }

    public function create()
    {
        return $this->render('modules.master.order.create');
    }

    public function store(OrderRequest $request)
    {
        // dd($request->all());
        $record = new Order;
        $record->fill($request->all());
        $record->save();


        return response([
            'status' => true
        ]);
    }

    public function edit($id)
    {
        $record = Order::find($id);

        return $this->render('modules.master.order.edit', [
            'record' => $record
        ]);
    }

    public function update(OrderRequest $request, $id)
    {
        $record = Order::find($id);
        $record->fill($request->all());
        $record->save();

        return response([
            'status' => true
        ]);
    }

    public function destroy($id)
    {
        $record = Order::find($id);
        $record->delete();

        return response([
            'status' => true,
        ]);
    }
}
