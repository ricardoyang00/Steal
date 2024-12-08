<h3>Hi {{ $mailData['name'] }},</h3>

<p>You requested a password reset for your STEAL! account.</p>
<p>Click the link below to reset your password:</p>

<p><a href="{{ $mailData['resetLink'] }}">{{ $mailData['resetLink'] }}</a></p>

<p>If you did not request this, please ignore this email.</p>

<h5>-------</h5>
<h5>Steal! Staff</h5>
