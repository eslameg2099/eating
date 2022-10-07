<?php

namespace App\Observers;

use DB;
use Notification;
use App\Models\Vote;
use App\Models\Review;
use App\Models\Kitchen;
use App\Notifications\MakeReviewNotification;

class VoteObserver
{
    /**
     * Handle the Vote "created" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function created(Vote $vote)
    {
        $review = Review::where('kitchen_id', $vote->kitchen_id)->first();
        $kitchen = Kitchen::where('id', $vote->kitchen_id)->first();
        if (! $review) {
            $review = $vote->review()->create([
            'kitchen_id' => $vote->kitchen_id,
        ]);
        }
//        TODO : Collect reviews sum in every time
        $sum_rate = Vote::where('kitchen_id', $vote->kitchen_id)->sum('rate');
        $rate = ($sum_rate / ++$review->reviewers);
        $review->update([
           'reviewers' => DB::raw('reviewers+1') ,
            'rate' => $rate,
        ]);
        $kitchen->update([
            'reviewers' => DB::raw('reviewers+1') ,
            'rate' => $rate,
        ]);
    }

    /**
     * Handle the Vote "updated" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function updated(Vote $vote)
    {
        //
    }

    /**
     * Handle the Vote "deleted" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function deleted(Vote $vote)
    {
        //
    }

    /**
     * Handle the Vote "restored" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function restored(Vote $vote)
    {
        //
    }

    /**
     * Handle the Vote "force deleted" event.
     *
     * @param  \App\Models\Vote  $vote
     * @return void
     */
    public function forceDeleted(Vote $vote)
    {
        //
    }
}
