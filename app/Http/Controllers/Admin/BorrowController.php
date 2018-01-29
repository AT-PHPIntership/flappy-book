<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Borrow;
use App\Model\User;
use App\Mail\ReminderedUser;
use Mail;

class BorrowController extends Controller
{
    /**
     * Display a listing of the borrower.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'users.employ_code',
            'users.name',
            'users.email',
            'books.title',
            'borrows.from_date',
            'borrows.to_date',
            'borrows.id',
            'borrows.user_id'
        ];
        $borrows = Borrow::select($fields)
        ->join('users', 'users.id', '=', 'borrows.user_id')
        ->join('books', 'books.id', '=', 'borrows.book_id')
        ->where('borrows.status', Borrow::BORROWING)
        ->sortable()
        ->orderby('from_date', 'desc')
        ->paginate(config('define.borrows.limit_rows'));

        return view('backend.borrows.index', ['borrows' => $borrows]);
    }

    /**
    * Send mail reminder user borrow book along time.
    *
    * @param int $id call borrows have id = $id
    *
    * @return \Illuminate\Http\Response
    */
    public function reminderSendMail($id)
    {
        $borrower = Borrow::findOrFail($id);
        $userId = $borrower->user_id;
        $user = User::findOrFail($userId);
        Mail::to($user->email)->send(new ReminderedUser());
        if (Mail::failures()) {
            flash(__('borrows.send_mail_fail'))->error();
        } else {
            $sendDate = date("Y-m-d");
            if (Borrow::findOrFail($id)->update(['to_date' => $sendDate])) {
                flash(__('borrows.send_mail_success'))->success();
            }
        }

        return redirect()->back();
    }
}
