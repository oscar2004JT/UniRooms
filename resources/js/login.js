export function createLoginPage(appState, createElement, showNotification, validateEmail) {
  const loginPage = document.querySelector('.login-container');

  function render(state) {
    const userRole = document.querySelector('#user-role');
    const studentToggle = document.querySelector('#login-student-toggle');
    const ownerToggle = document.querySelector('#login-owner-toggle');
    const loginForm = document.querySelector('#login-form');
    const backToHome = document.querySelector('#back-to-home');
    const forgotPassword = document.querySelector('#forgot-password');
    const registerLink = document.querySelector('#register-link');
    const googleLogin = document.querySelector('#google-login');
    const facebookLogin = document.querySelector('#facebook-login');

    if (userRole) {
      userRole.textContent = state.userType === 'student' ? 'Estudiante' : 'Propietario';
    }

    studentToggle?.addEventListener('click', () => appState.setState({ userType: 'student' }));
    ownerToggle?.addEventListener('click', () => appState.setState({ userType: 'owner' }));

    backToHome?.addEventListener('click', () => appState.setView('home'));

    forgotPassword?.addEventListener('click', (e) => {
      e.preventDefault();
      showNotification('Funcionalidad de recuperación de contraseña próximamente', 'info');
    });

    registerLink?.addEventListener('click', (e) => {
      e.preventDefault();
      showNotification('Funcionalidad de registro próximamente', 'info');
    });

    googleLogin?.addEventListener('click', () =>
      showNotification('Inicio de sesión con Google próximamente', 'info')
    );

    facebookLogin?.addEventListener('click', () =>
      showNotification('Inicio de sesión con Facebook próximamente', 'info')
    );

    loginForm?.addEventListener('submit', (e) => {
      e.preventDefault();

      const email = loginForm.querySelector('#email').value;
      const password = loginForm.querySelector('#password').value;

      if (!email || !password) {
        showNotification('Por favor completa todos los campos', 'error');
        return;
      }

      if (!validateEmail(email)) {
        showNotification('Por favor ingresa un email válido', 'error');
        return;
      }

      setTimeout(() => {
        appState.login({ email, password });
        showNotification(
          `¡Bienvenido ${state.userType === 'student' ? 'Estudiante' : 'Propietario'}!`,
          'success'
        );
      }, 1000);
    });

    setTimeout(() => {
      if (window.lucide) lucide.createIcons();
    }, 100);
  }

  appState.subscribe((state) => {
    if (state.currentView === 'login') render(state);
  });

  render(appState.state);
}
