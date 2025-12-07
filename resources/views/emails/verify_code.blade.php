<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Econnect Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #4E3A2E;
            background-color: #F8F4E7;
            padding: 20px;
        }
        
        .email-container {
            max-width: 550px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(74, 102, 19, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #4A6613 0%, #5A6B4A 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path d="M50,5 C70,5 85,20 85,40 C85,60 70,75 50,75 C30,75 15,60 15,40 C15,20 30,5 50,5 Z" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/></svg>');
            opacity: 0.3;
        }
        
        .logo {
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .logo i {
            color: #C8D5BB;
        }
        
        .tagline {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            font-weight: 300;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 28px;
            color: #4A6613;
            margin-bottom: 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .greeting i {
            color: #9BAF8D;
        }
        
        .intro-text {
            font-size: 16px;
            color: #4E3A2E;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        
        .verification-box {
            background: linear-gradient(135deg, #F8F4E7 0%, #FFF 100%);
            border-radius: 15px;
            padding: 35px;
            margin: 35px 0;
            text-align: center;
            border: 2px solid #C8D5BB;
            position: relative;
            overflow: hidden;
        }
        
        .verification-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #4A6613 0%, #9BAF8D 50%, #C8D5BB 100%);
        }
        
        .code-label {
            color: #4A6613;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .verification-code {
            font-family: 'Monaco', 'Courier New', monospace;
            font-size: 48px;
            font-weight: 700;
            color: #4A6613;
            letter-spacing: 8px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            border: 2px dashed #9BAF8D;
            margin: 20px 0;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(74, 102, 19, 0.1);
        }
        
        .code-hint {
            color: #8A9A7B;
            font-size: 14px;
            margin-top: 10px;
        }
        
        .instructions-box {
            background: #F8F4E7;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #9BAF8D;
        }
        
        .instructions-title {
            color: #4A6613;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .steps-list {
            list-style: none;
            counter-reset: step-counter;
        }
        
        .steps-list li {
            counter-increment: step-counter;
            padding: 12px 0 12px 45px;
            position: relative;
            border-bottom: 1px solid #E8E4D7;
        }
        
        .steps-list li:last-child {
            border-bottom: none;
        }
        
        .steps-list li::before {
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: #4A6613;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }
        
        .action-box {
            text-align: center;
            margin: 30px 0;
            padding: 25px;
            background: white;
            border-radius: 15px;
            border: 2px solid #E8E4D7;
        }
        
        .action-title {
            color: #4A6613;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 30px;
            background: #4A6613;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            margin-top: 15px;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: #3a5010;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(74, 102, 19, 0.2);
        }
        
        .warning-box {
            background: #FFF5F5;
            border-radius: 15px;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid #E53E3E;
        }
        
        .warning-title {
            color: #C53030;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer {
            background: #5A6B4A;
            color: white;
            padding: 30px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        
        .support-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-size: 14px;
        }
        
        .copyright {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-top: 20px;
        }
        
        .leaf-decoration {
            text-align: center;
            color: #8A9A7B;
            font-size: 24px;
            margin: 20px 0;
            letter-spacing: 15px;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 25px 20px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .greeting {
                font-size: 24px;
            }
            
            .verification-code {
                font-size: 36px;
                letter-spacing: 5px;
                padding: 15px;
            }
            
            .leaf-decoration {
                letter-spacing: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <i class="fas fa-leaf"></i>
                Econnect
            </div>
            <p class="tagline">Welcome to Our Sustainable Community</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <h1 class="greeting">
                <i class="fas fa-user-check"></i>
                Hello {{ $user->first_name }},
            </h1>
            
            <p class="intro-text">
                Thank you for joining <strong>Econnect</strong>! We're excited to have you as part of our 
                sustainable living community. To ensure the security of your account, please verify your email address.
            </p>
            
            <div class="leaf-decoration">
                <i class="fas fa-seedling"></i>
                <i class="fas fa-leaf"></i>
                <i class="fas fa-tree"></i>
            </div>
            
            <!-- Verification Code -->
            <div class="verification-box">
                <div class="code-label">
                    <i class="fas fa-key"></i>
                    Your Verification Code
                </div>
                
                <div class="verification-code">
                    {{ $user->verification_code }}
                </div>
                
                <p class="code-hint">
                    <i class="fas fa-clock"></i>
                    This code expires in 30 minutes
                </p>
            </div>
            
            <!-- Instructions -->
            <div class="instructions-box">
                <div class="instructions-title">
                    <i class="fas fa-list-ol"></i>
                    How to Verify Your Account
                </div>
                <ol class="steps-list">
                    <li>Return to the Econnect website or app</li>
                    <li>Navigate to the verification page</li>
                    <li>Enter the 6-digit code shown above</li>
                    <li>Click "Verify Account" to complete registration</li>
                </ol>
            </div>
            
            <!-- Warning -->
            <div class="warning-box">
                <div class="warning-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Important Security Notice
                </div>
                <p style="font-size: 14px; color: #4E3A2E;">
                    <strong>Never share this code with anyone.</strong> Econnect will never ask for your 
                    verification code via email, phone, or text message. If you didn't request this code, 
                    please ignore this email.
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                
                <p class="copyright">
                    © {{ date('Y') }} Econnect. All rights reserved.<br>
                    <small>This is an automated verification email. Please do not reply to this message.</small>
                </p>
            </div>
        </div>
    </div>
</body>
</html>