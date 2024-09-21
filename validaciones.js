window.onload = function() {
    alert("La página web está funcionando correctamente.");
};

document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Detiene el envío del formulario si hay errores
    
    const password = document.getElementById('passwordForm').value;
    const confirmPassword = document.getElementById('confirmPasswordForm').value;
    const email = document.getElementById('emailForm').value;

    // Validar contraseña
    if (!validatePassword(password)) {
        return; // Detiene el envío si la contraseña es inválida
    }

    // Validar coincidencia de contraseñas
    if (password !== confirmPassword) {
        alert("Las contraseñas no coinciden.");
        return;
    }

    // Validar correo
    if (!validateEmail(email)) {
        return; // Detiene el envío si el correo es inválido
    }

    // Si todas las validaciones pasan, permite el envío del formulario
    alert("Formulario enviado correctamente.");
    this.submit();  // Envía el formulario si todo está correcto
});

function validatePassword(password) {
    const minLength = 8;
    const hasUpperCase = /[A-Z]/.test(password); // Al menos una mayúscula
    const hasNumber = /\d/.test(password); // Al menos un número
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password); // Al menos un carácter especial

    if (password.length < minLength) {
        alert("La contraseña debe tener al menos 8 caracteres.");
        return false;
    }
    if (!hasUpperCase) {
        alert("La contraseña debe tener al menos una letra mayúscula.");
        return false;
    }
    if (!hasNumber) {
        alert("La contraseña debe tener al menos un número.");
        return false;
    }
    if (!hasSpecialChar) {
        alert("La contraseña debe tener al menos un carácter especial.");
        return false;
    }
    return true;
}

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Por favor, ingresa un correo electrónico válido que incluya '@' y un dominio como '.com'.");
        return false;
    }
    return true;
}