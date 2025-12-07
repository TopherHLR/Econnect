<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Login Detected</title>
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
            max-width: 600px;
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
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .greeting span {
            color: #5A6B4A;
        }
        
        .message {
            font-size: 16px;
            color: #4E3A2E;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        
        .info-box {
            background: #F8F4E7;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #4A6613;
        }
        
        .info-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4A6613;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .info-title i {
            color: #9BAF8D;
        }
        
        .info-list {
            list-style: none;
        }
        
        .info-list li {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #E8E4D7;
        }
        
        .info-list li:last-child {
            border-bottom: none;
        }
        
        .info-list i {
            color: #8A9A7B;
            width: 20px;
            margin-right: 10px;
        }
        
        .label {
            font-weight: 600;
            color: #4A6613;
            min-width: 120px;
        }
        
        .value {
            color: #4E3A2E;
        }
        
        .action-box {
            background: linear-gradient(135deg, #F8F4E7 0%, #FFF 100%);
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
            border: 2px solid #C8D5BB;
        }
        
        .action-title {
            color: #4A6613;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #4A6613;
            color: white;
        }
        
        .btn-primary:hover {
            background: #3a5010;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 102, 19, 0.2);
        }
        
        .btn-secondary {
            background: #C8D5BB;
            color: #4A6613;
        }
        
        .btn-secondary:hover {
            background: #B8C5AB;
            transform: translateY(-2px);
        }
        
        .security-tip {
            background: #FFF;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            border: 1px solid #E8E4D7;
        }
        
        .security-tip h3 {
            color: #4A6613;
            font-size: 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .tip-list {
            list-style: none;
            margin-left: 5px;
        }
        
        .tip-list li {
            padding: 5px 0;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .tip-list i {
            color: #9BAF8D;
            margin-top: 3px;
        }
        
        .footer {
            background: #5A6B4A;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        
        .social-icons a {
            color: #C8D5BB;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        
        .social-icons a:hover {
            color: white;
        }
        
        .copyright {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-top: 10px;
        }
        
        .leaf-decoration {
            text-align: center;
            color: #8A9A7B;
            font-size: 24px;
            margin: 20px 0;
            letter-spacing: 10px;
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
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .info-list li {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .label {
                min-width: auto;
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
            <p class="tagline">Sustainable Living Community</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <h1 class="greeting">Hello, <span>{{ $user->first_name }}</span>!</h1>
            
            <div class="leaf-decoration">
                <i class="fas fa-seedling"></i>
                <i class="fas fa-leaf"></i>
                <i class="fas fa-tree"></i>
            </div>
            
            <p class="message">
                We noticed a new login to your <strong>Econnect</strong> account. Your security is important to us, 
                so we're keeping you informed about account activity.
            </p>
            
            <!-- Login Details -->
            <div class="info-box">
                <div class="info-title">
                    <i class="fas fa-shield-alt"></i>
                    Login Details
                </div>
                <ul class="info-list">
                    <li>
                        <i class="fas fa-user-circle"></i>
                        <span class="label">Account:</span>
                        <span class="value">{{ $user->email }}</span>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="label">IP Address:</span>
                        <span class="value">{{ $ip }}</span>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span class="label">Time:</span>
                        <span class="value">{{ $time }}</span>
                    </li>
                </ul>
            </div>
            
            <!-- Security Tips -->
            <div class="security-tip">
                <h3><i class="fas fa-lightbulb"></i> Security Tips</h3>
                <ul class="tip-list">
                    <li>
                        <i class="fas fa-check"></i>
                        Use a strong, unique password for your Econnect account
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        Enable two-factor authentication for added security
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        Never share your login credentials with anyone
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div style="font-weight: 600; font-size: 18px;">
                    <i class="fas fa-leaf" style="margin-right: 8px;"></i>
                    Econnect Security Team
                </div>
                <p style="opacity: 0.9; max-width: 400px; margin: 0 auto;">
                    Committed to protecting your sustainable journey
                </p>
                
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
                
                <p class="copyright">
                    © {{ date('Y') }} Econnect. All rights reserved.<br>
                    <small>This is an automated security notification. Please do not reply to this email.</small>
                </p>
            </div>
        </div>
    </div>
</body>
</html>