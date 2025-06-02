const container = document.getElementById('container');
const toSignUp = document.getElementById('toSignUp');
const toSignIn = document.getElementById('toSignIn');
const forgotPasswordLink = document.getElementById('forgotPassword');

toSignUp.addEventListener('click', () => {
  container.classList.add('right-panel-active');
  container.classList.remove('forgot-active');
});

toSignIn.addEventListener('click', () => {
  container.classList.remove('right-panel-active');
  container.classList.remove('forgot-active');
});

forgotPasswordLink.addEventListener('click', () => {
  container.classList.add('forgot-active');
});
