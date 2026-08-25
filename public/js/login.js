    // Expand / Collapse Panel
    const togglePanelBtn = document.getElementById('togglePanelBtn');
    const loginWrapper = document.getElementById('loginWrapper');

    togglePanelBtn.addEventListener('click', function() {
        loginWrapper.classList.toggle('expand-left');
    });

    // Toggle Password
    function togglePassword() {
        const passInput = document.getElementById('password');
        passInput.type = passInput.type === 'password' ? 'text' : 'password';
    }

    // Submit Animation
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btnSubmit = document.getElementById('btnSubmit');
        document.getElementById('btnSpinner').style.display = 'inline-block';
        document.getElementById('btnText').textContent = 'Logging in...';
        btnSubmit.style.opacity = '0.85';
        btnSubmit.style.pointerEvents = 'none';
    });