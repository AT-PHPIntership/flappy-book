<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Qrcode;
use Excel;
use DB;
use Exception;

class QrcodeController extends Controller
{

    /**
     * Display a listing of the qrcodes.
     *
     * @param Request $request send request
     *
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if ($request->has('export')) {
            $this->exportQrcodes();
        }

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

    /**
     * Export file list qrcode not print yet.
     *
     * @return \Illuminate\Http\Response
    */
    public function exportQrcodes()
    {
        try {
            $fields = [
                'qrcodes.id',
                'books.title',
                DB::raw('CONCAT(prefix, IF(LENGTH(code_id) < ' . Qrcode::LENGTH_OF_QRCODE . ', LPAD(code_id, ' . Qrcode::LENGTH_OF_QRCODE . ', 0), code_id)) AS qrcode'),
            ];
            $qrcodes = Qrcode::select($fields)
            ->join('books', 'books.id', '=', 'qrcodes.book_id')
            ->where('qrcodes.status', Qrcode::IS_NOT_PRINTED)
            ->get()
            ->toArray();
            if (!empty($qrcodes)) {
                Excel::create('Qrcodes', function ($excel) use ($qrcodes) {
                    $excel->sheet('Export Qrcode', function ($sheet) use ($qrcodes) {
                        $sheet->fromArray($qrcodes);
                    });
                    DB::table('qrcodes')
                        ->where('status', Qrcode::IS_NOT_PRINTED)
                        ->update(['status' => Qrcode::IS_PRINTED]);
                })->export(config('define.qrcodes.format_file_export'));
            } else {
                flash(__('qrcodes.download_failed'))->error();
                return redirect()->route('qrcodes.index');
            }
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->back();
        }
    }
}
