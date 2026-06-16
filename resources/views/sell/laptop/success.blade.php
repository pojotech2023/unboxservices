{{-- resources/views/sell/laptop/success.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Successful - Sell Laptop</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* SUCCESS PAGE ONLY STYLES - Isolated with unique class names */
        .sell-success-page {
            background: #f4f6f8;
            font-family: 'Nunito Sans', sans-serif;
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .sell-success-page * {
            box-sizing: border-box;
        }
        
        .sell-success-container {
            max-width: 700px;
            margin: 0 auto;
        }
        
        .sell-success-card { 
            background: #ffffff; 
            border-radius: 20px; 
            padding: 50px 40px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
        }
        
        .sell-success-icon { 
            width: 100px; 
            height: 100px; 
            background: #e8f5e9; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 30px; 
            font-size: 50px;
            line-height: 1;
        }
        
        .sell-success-title { 
            font-family: 'Nunito', sans-serif; 
            font-size: 32px; 
            font-weight: 900; 
            color: #1a1a1a; 
            margin-bottom: 15px;
            line-height: 1.2;
        }
        
        .sell-success-message { 
            font-size: 18px; 
            color: #555555; 
            line-height: 1.6; 
            margin-bottom: 30px;
        }
        
        .sell-success-message strong {
            color: #1a1a1a;
            font-weight: 700;
        }
        
        .sell-success-highlight { 
            background: #fff3e0; 
            border: 2px solid #ff9800; 
            border-radius: 12px; 
            padding: 20px; 
            margin: 30px 0; 
        }
        
        .sell-success-highlight-text { 
            font-family: 'Nunito', sans-serif; 
            font-size: 17px; 
            font-weight: 800; 
            color: #e65100; 
            line-height: 1.5;
            margin: 0;
        }
        
        .sell-price-display { 
            font-family: 'Nunito', sans-serif; 
            font-size: 52px; 
            font-weight: 900; 
            color: #e53935; 
            margin: 25px 0; 
            line-height: 1;
        }
        
        .sell-price-display .sell-currency { 
            font-size: 28px; 
            vertical-align: super; 
            font-weight: 800;
            margin-right: 5px;
        }
        
        .sell-device-info { 
            background: #f8f9fa; 
            border-radius: 12px; 
            padding: 25px 30px; 
            margin: 30px 0; 
            text-align: left;
        }
        
        .sell-device-info-row { 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            padding: 12px 0; 
            border-bottom: 1px solid #e0e0e0; 
        }
        
        .sell-device-info-row:last-child { 
            border-bottom: none; 
        }
        
        .sell-device-info-label { 
            color: #888888; 
            font-size: 14px; 
            font-weight: 600;
            font-family: 'Nunito Sans', sans-serif;
        }
        
        .sell-device-info-value { 
            font-weight: 700; 
            color: #333333; 
            font-size: 15px; 
            text-align: right;
            font-family: 'Nunito', sans-serif;
        }
        
        .sell-btn-home { 
            display: inline-block; 
            background: #00bfa5; 
            color: #ffffff; 
            font-family: 'Nunito', sans-serif; 
            font-size: 16px; 
            font-weight: 800; 
            padding: 15px 50px; 
            border-radius: 10px; 
            text-decoration: none; 
            transition: all 0.3s ease; 
            margin-top: 20px; 
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,191,165,0.3);
        }
        
        .sell-btn-home:hover { 
            background: #00897b; 
            box-shadow: 0 6px 20px rgba(0,191,165,0.4); 
            transform: translateY(-2px);
        }
        
        .sell-verification-badge { 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            background: #e8f5e9; 
            color: #2e7d32; 
            padding: 12px 24px; 
            border-radius: 25px; 
            font-size: 14px; 
            font-weight: 700; 
            margin-top: 25px;
            font-family: 'Nunito', sans-serif;
        }
        
        .sell-verification-badge::before {
            content: "✓";
            width: 22px;
            height: 22px;
            background: #4caf50;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
        }
        
        .sell-evaluation-id {
            margin-top: 25px;
            font-size: 13px;
            color: #888888;
            font-weight: 600;
            font-family: 'Nunito Sans', sans-serif;
        }
        
        /* Error state styles */
        .sell-error-container {
            text-align: center;
            padding: 60px 20px;
        }
        
        .sell-error-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .sell-error-title {
            font-family: 'Nunito', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #333333;
            margin-bottom: 15px;
        }
        
        .sell-error-message {
            color: #666666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) { 
            .sell-success-page {
                padding: 20px 15px;
            }
            
            .sell-success-card { 
                padding: 30px 20px; 
            }
            
            .sell-success-title { 
                font-size: 24px; 
            } 
            
            .sell-price-display { 
                font-size: 38px; 
            } 
            
            .sell-price-display .sell-currency {
                font-size: 22px;
            }
            
            .sell-success-highlight-text {
                font-size: 15px;
            }
            
            .sell-device-info {
                padding: 20px;
            }
            
            .sell-device-info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .sell-device-info-value {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    @include('sell.partials.navbar')

    <div class="sell-success-page">
        <div class="sell-success-container">
            @if(isset($name) && isset($price))
            <div class="sell-success-card">
                <div class="sell-success-icon">🎉</div>
                
                <h1 class="sell-success-title">Evaluation Submitted Successfully!</h1>
                
                <p class="sell-success-message">
                    Thank you <strong>{{ $name }}</strong> for evaluating your laptop with us.
                </p>

                <div class="sell-price-display">
                    <span class="sell-currency">₹</span>{{ number_format($price, 0) }}
                </div>

                <div class="sell-success-highlight">
                    <p class="sell-success-highlight-text">
                        ⚡ Our team member will come to your address and check to give you the exact price.
                    </p>
                </div>

                <div class="sell-device-info">
                    <div class="sell-device-info-row">
                        <span class="sell-device-info-label">Brand</span>
                        <span class="sell-device-info-value">{{ $brand ?? 'N/A' }}</span>
                    </div>
                    <div class="sell-device-info-row">
                        <span class="sell-device-info-label">Model</span>
                        <span class="sell-device-info-value">{{ $model ?? 'N/A' }}</span>
                    </div>
                    @if(isset($variant) && $variant)
                    <div class="sell-device-info-row">
                        <span class="sell-device-info-label">Variant</span>
                        <span class="sell-device-info-value">{{ $variant }}</span>
                    </div>
                    @endif
                    <div class="sell-device-info-row">
                        <span class="sell-device-info-label">Mobile</span>
                        <span class="sell-device-info-value">+91 {{ $mobile ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="sell-verification-badge">
                    OTP Verified Successfully
                </div>

                <div style="margin-top: 30px;">
                    <a href="{{ route('sell.index') }}" class="sell-btn-home">Back to Home</a>
                </div>

                @if(isset($evaluation_id))
                <div class="sell-evaluation-id">
                    Evaluation ID: #{{ $evaluation_id }}
                </div>
                @endif
            </div>
            @else
            <div class="sell-success-card sell-error-container">
                <div class="sell-error-icon">⚠️</div>
                <h2 class="sell-error-title">No Evaluation Data Found</h2>
                <p class="sell-error-message">Please complete the evaluation process again.</p>
                <a href="{{ route('sell.laptop.index') }}" class="sell-btn-home">Start New Evaluation</a>
            </div>
            @endif
        </div>
    </div>
</body>
</html>