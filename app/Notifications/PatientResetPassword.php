<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

/**
 * Password reset email for patient accounts. Laravel's default notification
 * links to the "password.reset" route (the staff broker), so patients need
 * the portal-scoped route instead.
 */
class PatientResetPassword extends ResetPassword
{
    /**
     * Build the portal reset URL for the notification.
     */
    protected function resetUrl(mixed $notifiable): string
    {
        return route('patient.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);
    }
}
