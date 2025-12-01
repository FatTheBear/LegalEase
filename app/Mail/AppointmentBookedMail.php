<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentBookedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $client;
    public $lawyer;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $client, $lawyer)
    {
        $this->appointment = $appointment;
        $this->client = $client;
        $this->lawyer = $lawyer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Booking Confirmation - LegalEase',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-booked',
            with: [
                'appointment' => $this->appointment,
                'client' => $this->client,
                'lawyer' => $this->lawyer,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
