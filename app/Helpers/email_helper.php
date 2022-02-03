<?php
use Config\Services;

if (!function_exists('email_send_password_reset'))
{
    function email_send_password_reset($to, $newTempPassword)
    {
        $htmlMessage = view('App\Views\emails\header');
        $htmlMessage .= view('App\Views\emails\reset', ['password' => $newTempPassword]);
        $htmlMessage .= view('App\Views\emails\footer');

        $email = \Config\Services::email();
        $email->initialize([
            'mailType' => 'html',
            'protocol' => 'smtp',
            'validate' => false
        ]);

        $email->setTo($to);
        $email->setFrom('noreply@yeelt.io', 'Yeelt');
        $email->setSubject('Wachtwoord herstel');
        $email->setMessage($htmlMessage);

        if(!$email->send()){
            if(ENVIRONMENT == 'development') { $email->printDebugger(); exit(); } // Print debugger in development
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

if (!function_exists('email_send_invite'))
{
    function email_send_invite($data)
    {
        $htmlMessage = view('App\Views\emails\header');
        $htmlMessage .= view('App\Views\emails\invite', $data);
        $htmlMessage .= view('App\Views\emails\footer');

        $email = \Config\Services::email();
        $email->initialize([
            'mailType' => 'html',
            'protocol' => 'smtp',
            'validate' => false
        ]);

        $email->setTo($data['emailaddress']);
        $email->setFrom('info@yeelt.io', 'Yeelt');
        $email->setSubject('You Are Invited!');
        $email->setMessage($htmlMessage);

        if(!$email->send()){
            if(ENVIRONMENT == 'development') { $email->printDebugger(); exit(); } // Print debugger in development
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function email_send_verify_email($to, $token)
    {   $data['token'] = $token;        
        $data['email'] = $to;
        $htmlMessage = view('App\Views\emails\header');
        $htmlMessage .= view('App\Views\emails\verify', $data);
        $htmlMessage .= view('App\Views\emails\footer');

        $email = \Config\Services::email();
        $email->initialize([
            'mailType' => 'html',
            'protocol' => 'smtp',
            'validate' => false
        ]);

        $email->setTo($data['email']);
        $email->setFrom('info@yeelt.io', 'Yeelt');
        $email->setSubject('Email Address Verify');
        $email->setMessage($htmlMessage);

        if(!$email->send()){
            if(ENVIRONMENT == 'development') { echo $email->printDebugger(); exit(); } // Print debugger in development
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

