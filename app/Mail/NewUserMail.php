<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserMail extends Mailable
{
    use Queueable, SerializesModels;


    private $user;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( User $user )
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
        return $this->view( 'emails.new-user' )
                    ->subject( 'Tennis MolodNd' )
                    ->from( 'tennisnd@yandex.ru', 'Новый пользователь Tennis MolodNd' )
                    ->with( [ 'user' => $this->user ] )
                    ->bcc( 'vptrv.pr@gmail.com' )
                    ->to( 'tennisnd@yandex.ru' );
    }
}
