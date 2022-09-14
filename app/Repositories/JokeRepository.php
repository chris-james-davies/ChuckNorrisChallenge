<?php

namespace App\Repositories;

use App\Mail\JokeEmail;
use App\Models\JokeRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class JokeRepository
{
    protected $emailRepo;

    public function __construct()
    {
        $this->emailRepo = new EmailRepository();
    }


    public function createRequest($request)
    {
        $jokeRequest = JokeRequest::create([
            'status' => 'open',
            'ip_address' => $request['ip_address'],
        ]);

        foreach ($request['emails'] as $email) {
            $record = $this->emailRepo->create($email);
            $jokeRequest->emails()->attach($record);
        }

        return $jokeRequest;
    }

    public function confirm(JokeRequest $request)
    {
        $request->status = "confirm";

        $emails = $request->emails->pluck('email')->toArray();

        $this->sendJokes($emails);

        return true;
    }

    public function sendJokes($emails)
    {
        $jokes = $this->fetchJokes(count($emails));
        
        $jokesCollection = collect($jokes->value);

        foreach ($emails as $email) {
            $joke = $jokesCollection->shift();
            Mail::to($email)->send(new JokeEmail($joke));
        }
    }

    public function find($id)
    {
        return JokeRequest::find($id);
    }

    private function fetchJokes($count)
    {
        $response = Http::get('http://api.icndb.com/jokes/random/'.$count.'?exclude=[explicit]');
        $json = $response->body();

        $jokes = json_decode($json);

        return $jokes;
    }
}