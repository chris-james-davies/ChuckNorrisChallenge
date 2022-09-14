<?php

namespace App\Repositories;

use App\Models\Email;

class EmailRepository
{
    protected $invalidEmails = [];

    public function create($email)
    {
        return Email::updateOrCreate([
            'email' => $email
        ]);
    }

    public function validateEmailDomains($emails)
    {
        $validEmails = [];

        foreach ($emails as $email) {
            list($user,$domain) = explode("@",$email,2);
            if(checkdnsrr($domain)) {
                $validEmails[] = $email;
            } else {
                $this->invalidEmails[] = $email;
            }
        }

        return $validEmails;
    }

    public function sortEmails($emails)
    {
        $emailsList = [];
        foreach ($emails as $email) {
            list($user,$domain) = explode("@",$email,2);
            if (!isset($emailsList[$domain])) $emailsList[$domain] = [];
            if (!in_array($user,$emailsList[$domain])) $emailsList[$domain][] = $user;
        }

        ksort($emailsList);
        
        $sortedList = [];

        foreach ($emailsList as $domain => $list) {
            sort($list);
            foreach ($list as $user) {
                $sortedList[] = $user."@".$domain;
            }
        }

        return $sortedList;
    }

    public function getInvalidEmails()
    {
        return $this->invalidEmails;
    }
}