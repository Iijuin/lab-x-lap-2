@props(['id' => 'password'])

<div class="password-strength-container">
    <div class="strength-meter">
        <div class="strength-meter-fill" data-strength="0"></div>
    </div>
    <p class="strength-text text-sm mt-1">Kekuatan password: <span class="strength-value">Lemah</span></p>
</div>

<style>
    .password-strength-container {
        margin-top: 0.5rem;
    }
    
    .strength-meter {
        height: 4px;
        background-color: #e2e8f0;
        border-radius: 2px;
        overflow: hidden;
    }
    
    .strength-meter-fill {
        height: 100%;
        width: 0;
        transition: width 0.3s ease, background-color 0.3s ease;
    }
    
    .strength-meter-fill[data-strength="0"] {
        width: 0;
        background-color: #ef4444;
    }
    
    .strength-meter-fill[data-strength="1"] {
        width: 25%;
        background-color: #ef4444;
    }
    
    .strength-meter-fill[data-strength="2"] {
        width: 50%;
        background-color: #f59e0b;
    }
    
    .strength-meter-fill[data-strength="3"] {
        width: 75%;
        background-color: #10b981;
    }
    
    .strength-meter-fill[data-strength="4"] {
        width: 100%;
        background-color: #059669;
    }
    
    .strength-text {
        color: #6b7280;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('{{ $id }}');
    const strengthMeter = document.querySelector('.strength-meter-fill');
    const strengthValue = document.querySelector('.strength-value');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        // Panjang password
        if (password.length >= 8) strength++;
        
        // Mengandung huruf besar dan kecil
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        
        // Mengandung angka
        if (password.match(/\d/)) strength++;
        
        // Mengandung karakter khusus
        if (password.match(/[^a-zA-Z\d]/)) strength++;
        
        // Update tampilan
        strengthMeter.setAttribute('data-strength', strength);
        
        // Update teks
        const strengthTexts = ['Lemah', 'Cukup', 'Baik', 'Kuat', 'Sangat Kuat'];
        strengthValue.textContent = strengthTexts[strength];
        
        // Update warna teks
        const strengthColors = ['#ef4444', '#ef4444', '#f59e0b', '#10b981', '#059669'];
        strengthValue.style.color = strengthColors[strength];
    });
});
</script> 