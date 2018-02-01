<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Borrow;
use App\Model\User;
use App\Model\Book;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class ReminderedUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Declare borrowing
     *
     * @var Borrow $borrowing borrowing
     */
    public $borrowing;

    /**
     * Declare user
     *
     * @var User   $user      user
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param Borrow $borrowing borrowing
     * @param User   $user      user
     *
     * @return void
     */
    public function __construct(Borrow $borrowing, User $user)
    {
        $this->borrowing = $borrowing;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $locale = App::getLocale();
        $numberDateBorrowed = Carbon::now()->diffInDays(Carbon::parse($this->borrowing->from_date));
        $book = Book::findOrFail($this->borrowing->book_id);
        $subject =  __('borrows.subject_mail_reminder');
        return $this->view('backend.mails.'.$locale.'.sendmail', ['numberDateBorrowed' => $numberDateBorrowed, 'book' => $book])
                    ->from(Auth::user()->email, Auth::user()->name)
                    ->subject($subject);
    }
}
