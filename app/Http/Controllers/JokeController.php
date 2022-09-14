<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\JokeRepository;
use App\Http\Requests\JokeRequest;
use App\Repositories\EmailRepository;

class JokeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $jokeRepo, $emailRepo;

    public function __construct()
    {
        $this->jokeRepo = new JokeRepository();
        $this->emailRepo = new EmailRepository();
    }

    public function request(JokeRequest $request)
    {
        // Validate Email Domains
        $emails = $request->emails;
        if (!$this->emailsValid($emails)) {
            $errors = [];
            foreach ($this->emailRepo->getInvalidEmails() as $invalidEmail) {
                $errors[] = "Email $invalidEmail is on an invalid domain";
            }
            return $this->throwError($errors);
        }
        
        // Create Request
        $jokeRequest = $this->jokeRepo->createRequest([
            'ip_address' => $request->ip(),
            'emails' => $request->emails,
        ]);

        // Return Confirmation
        if ($jokeRequest) {
            return [
                "success" => true,
                "data"  => [
                    "request_id" => $jokeRequest->id,
                    "emails" => $this->emailRepo->sortEmails($jokeRequest->emails->pluck('email')->toArray())
                ]
            ];
        }

        return $this->throwError(['An Unknown Error Occurred']);
    }

    public function confirm(ConfirmRequest $request)
    {
        // Load Request
        $jokeRequest = $this->jokeRepo->find($request->id);

        // Confirm the Joke Request
        $this->jokeRepo->confirm($jokeRequest);

        // Send success message
        return [
            "success" => true,
        ];
    }

    private function emailsValid($emails)
    {
        $validEmails = $this->emailRepo->validateEmailDomains($emails);
        return count($emails) === count($validEmails);
    }

    private function throwError($errors)
    {
        return [
            "success" => false,
            "errors" => $errors
        ];
    }
}
