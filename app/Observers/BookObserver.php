<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Facades\Log;

class BookObserver
{
    protected $log;

    public function __construct()
    {
        $this->log = Log::channel('book_logs');
    }

    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        $this->log->info('Book created: ', ['id' => $book->id, 'title' => $book->title]);
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        $this->log->info('Book updated: ', ['id' => $book->id, 'title' => $book->title]);
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        $this->log->info('Book deleted: ', ['id' => $book->id, 'title' => $book->title]);
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        //
    }
}
