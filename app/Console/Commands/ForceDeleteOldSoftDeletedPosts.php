<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Carbon\Carbon;

class ForceDeleteOldSoftDeletedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:force-delete-old-soft-deleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force deletes all softly-deleted posts that are older than 30 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = Carbon::now()->subDays(30);

        $deletedCount = Post::onlyTrashed()
            ->where('deleted_at', '<', $threshold)
            ->forceDelete();

        $this->info("Force deleted {$deletedCount} softly-deleted posts older than 30 days.");
    }
}