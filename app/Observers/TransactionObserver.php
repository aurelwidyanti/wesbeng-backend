<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction)
    {
        if ($transaction->isDirty('status') && $transaction->status === 'approved') {
            $user = $transaction->user;

            if ($transaction->type === 'deposit') {
                $user->balance += $transaction->amount;
            } elseif ($transaction->type === 'withdraw') {
                $user->balance -= $transaction->amount;
            }

            $user->save();
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
