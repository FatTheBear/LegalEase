<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerifyAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Đảm bảo có verify_token
        if (!$this->user->verify_token) {
            $this->user->verify_token = \Str::random(64);
        }
        
        $verifyUrl = route('verify.email', ['token' => $this->user->verify_token]);
        
        return $this->view('emails.verify-account')
                    ->subject('Xác thực tài khoản - ' . config('app.name'))
                    ->with([
                        'user' => $this->user,
                        'verifyUrl' => $verifyUrl
                    ]);
    }
}