<?php

namespace App\Transformers;

use App\Model\User;
use App\Model\Borrow;
use League\Fractal\TransformerAbstract;
use League\Fractal\Item;
use Illuminate\Support\Facades\App;

class UserTransformer extends TransformerAbstract
{
    /**
     * The attributes that are available include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'book_borrowing',
        'donated',
        'borrowed'
    ];

    /**
     * Transform
     *
     * @param User $user user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'employ_code' => (string) $user->employ_code,
            'email' => (string) $user->email,
            'team' => (string) $user->team,
            'avatar_url' => (string) $user->avatar_url,
            'is_admin' => (int) $user->is_admin,
            'created_at' => (string) $user->created_at,
            'updated_at' => (string) $user->updated_at
        ];
    }

    /**
     * Include book borrowing
     *
     * @param User $user user
     *
     * @return Item
     */
    public function includeBookBorrowing(User $user)
    {
        $borrowing = $user->borrows->where('status', Borrow::BORROWING)->first();

        if (!$borrowing) {
            return $this->null();
        }
        return $this->item($borrowing->books, App::make(BookIncludeTransformer::class));
    }

    /**
     * Include amount of books donated
     *
     * @param User $user user
     *
     * @return Item
     */
    public function includeDonated(User $user)
    {
        return $this->item($user, function ($user) {
            $donated = $user->books->count();
            return ['amount' => $donated];
        });
    }

    /**
     * Include amount of books borrowed
     *
     * @param User $user user
     *
     * @return Item
     */
    public function includeBorrowed(User $user)
    {
        return $this->item($user, function ($user) {
            $borrowed = $user->borrows->groupBy('book_id')->count();
            return ['amount' => $borrowed];
        });
    }
}
