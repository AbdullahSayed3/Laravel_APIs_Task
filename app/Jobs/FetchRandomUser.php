<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchRandomUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = Http::get('https://randomuser.me/api/');

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['results'])) {
                    Log::info('RandomUser API Results:', ['results' => $data['results']]);
                } else {
                    Log::warning('RandomUser API response did not contain "results" key.', ['response' => $data]);
                }
            } else {
                Log::error('Failed to fetch data from RandomUser API.', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching data from RandomUser API: ' . $e->getMessage());
        }
    }
}