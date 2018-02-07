<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Qrcode;

class QrcodeController extends Controller
{

    /**
     * Display a listing of the qrcodes.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $fields = [
            'qrcodes.id',
            'qrcodes.prefix',
            'qrcodes.code_id',
        ];
        $qrcodes = Qrcode::select($fields)
            ->where('qrcodes.status', Qrcode::NOT_PRINT_STATUS)
            ->paginate(config('define.qrcodes.limit_rows'));
        return view('backend.qrcodes.index', ['qrcodes' => $qrcodes]);
    }
}
