<div class="password-reset-mail-container">
    <h3>Hi {{ $mailData['name'] }},</h3>
    <p>You requested a password reset for your STEAL! account.</p>
    <p>Click the button below to reset your password:</p>
    <p><a href="{{ $mailData['resetLink'] }}" class="button">Reset Password</a></p>
    <div class="note">
        <p>If you did not request this, please ignore this email.</p>
    </div>
    <div class="footer">
        <p>-------</p>
        <p>Steal! Staff</p>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    
    .password-reset-mail-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .password-reset-mail-container h3 {
        color: #333333;
    }
    .password-reset-mail-container p {
        color: #666666;
        line-height: 1.6;
    }
    .password-reset-mail-container a {
        color: #6a2efb;
        text-decoration: none;
    }
    .password-reset-mail-container .button {
        display: inline-block;
        padding: 12px 25px;
        margin-top: 20px;
        background-color: #6a2efb;
        color: #ffffff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }
    .password-reset-mail-container .button:hover {
        background-color: #5421c5;
    }
    .password-reset-mail-container .note {
        margin-top: 30px;
        font-size: 0.9rem;
        color: #999999;
        background-color: #f9f9f9;
        padding: 10px;
        border-left: 4px solid #dcdcdc;
        border-radius: 4px;
    }
    .password-reset-mail-container .footer {
        margin-top: 40px;
        text-align: center;
        color: #999999;
        font-size: 0.9rem;
    }
    .password-reset-mail-container .footer p {
        margin: 5px 0;
    }
</style>
