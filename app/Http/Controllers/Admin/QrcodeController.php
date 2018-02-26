<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'books.title',
        ];
        $qrcodes = Qrcode::select($fields)
            ->join('books', 'books.id', '=', 'qrcodes.book_id')
            ->where('qrcodes.status', Qrcode::IS_NOT_PRINTED)
            ->paginate(config('define.qrcodes.limit_rows'));
        return view('backend.qrcodes.index', ['qrcodes' => $qrcodes]);
    }
}
