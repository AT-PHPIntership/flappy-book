<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use App\Model\Qrcode;
use DB;

class ExcelController extends Controller
{

    /**
     * Download qrcode not print yet list.
     *
     * @return \Illuminate\Http\Response
    */
    public function exportQrcodeExcel()
    {
        $fields = [
            'qrcodes.id',
            'books.title',
            DB::raw('CONCAT(prefix, IF(LENGTH(code_id) < ' . Qrcode::NUMBER_OF_NUMBERS . ', CONCAT(repeat(0, ' . Qrcode::NUMBER_OF_NUMBERS . ' - LENGTH(code_id)), code_id), code_id)) as qrcode'),
        ];
        $qrcodes = Qrcode::select($fields)
            ->join('books', 'books.id', '=', 'qrcodes.book_id')
            ->where('qrcodes.status', Qrcode::NOT_PRINT_STATUS)
            ->get()->toArray();
            return \Excel::create('qrcodes_list', function ($excel) use ($qrcodes) {
                $excel->sheet('qrcodes list', function ($sheet) use ($qrcodes) {
                    $sheet->fromArray($qrcodes);
                });
            })->export('xls');
    }
}
