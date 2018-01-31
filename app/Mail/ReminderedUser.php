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
        $currentDate = date(config('define.borrows.current_date_format'));
        $borrowDate = $this->borrowing->from_date;
        $numberDateBorrowed = (strtotime($currentDate) - strtotime($borrowDate)) / (60 * 60 * 24);
        $bookId = $this->borrowing->book_id;
        $book = Book::findOrFail($bookId);
        $subject = 'Reminder User Borrowing Book';
        return $this->view('backend.mails.sendmail', ['numberDateBorrowed' => $numberDateBorrowed, 'book' => $book])
                    ->from(Auth::user()->email, Auth::user()->name)
                    ->subject($subject);
    }
}
