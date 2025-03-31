<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    
    <!-- Tailwind CSS + DaisyUI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css">
    <link rel="stylesheet" href="assets/css/login_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="utilities/sweetalert2/sweetalert2.min.css">
</head>
<body>
<div class="animated-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
        <div class="gradient-sphere sphere-3"></div>
        <div class="particles" id="particles"></div>
    </div>

    <div class="login-container">
    <div class="login-header">
        <h1>WorshipSet</h1>
        <p>Welcome! Log in to join your Worship Team and elevate the atmosphere!</p>
    </div>

    <form id="loginForm">
        <div class="form-group">
            <input 
                type="email" 
                class="form-input" 
                id="email" 
                placeholder="Enter your email"
                required
            >
            <i class="input-icon fas fa-envelope"></i>
            <span class="error-message" id="emailError"></span>
        </div>

        <div class="form-group">
            <input 
                type="password" 
                class="form-input" 
                id="password" 
                placeholder="Enter your password"
                required
            >
            <i class="input-icon fas fa-lock"></i>
            <span class="error-message" id="passwordError"></span>
        </div>

        <button id="btn_login" class="submit-button">Join Your Worship Team</button>
    </form>
</div>
<div id="message_container"></div>
<script src="utilities/js/jquery.js"></script>
<script src="utilities/sweetalert2/sweetalert2.min.js"></script>
<script src="login/js/login_event_controller.js"></script>
</body>
</html>
