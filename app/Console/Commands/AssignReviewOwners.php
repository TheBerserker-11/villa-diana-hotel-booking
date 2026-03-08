<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Review;
use App\Models\User;

class AssignReviewOwners extends Command
{
    protected $signature = 'reviews:assign-owners';
    protected $description = 'Assign user_id to old reviews based on name matching';

    public function handle()
    {
        $reviews = Review::whereNull('user_id')->get();
        $count = 0;

        foreach ($reviews as $review) {
            $user = User::where('name', $review->name)->first();
            if ($user) {
                $review->user_id = $user->id;
                $review->save();
                $count++;
                $this->info("Assigned user_id {$user->id} to review {$review->id}");
            }
        }

        $this->info("Done! {$count} reviews updated.");
    }
}
