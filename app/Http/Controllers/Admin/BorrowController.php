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
            'borrows.send_mail_date',
        ];
        $borrows = Borrow::search(request('search'), request('filter'))
            ->select($fields)
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
        $borrowing = Borrow::findOrFail($id);
        $userId = $borrowing->user_id;
        $user = User::findOrFail($userId);
        $email = new ReminderedUser($borrowing, $user);
        Mail::to($user->email)->send($email);
        if (Mail::failures()) {
            flash(__('borrows.send_mail_fail'))->error();
        } else {
            $sendDate = date(config('define.borrows.date_format_Ymd'));
            if (Borrow::findOrFail($id)->update(['send_mail_date' => $sendDate])) {
                flash(__('borrows.send_mail_success'))->success();
            }
        }

        return redirect()->back();
    }
}
