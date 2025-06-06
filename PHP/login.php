* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
}

body {
  background: url('assets/signin_background.png') no-repeat center center/cover;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container {
  position: relative;
  width: 900px;
  height: 500px;
  border-radius: 30px;
  overflow: hidden;
  display: flex;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  background-color: transparent;
}

/* Panel putih bergeser */
.switch-panel {
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  background: #f7fafa;
  border-radius: 30px 0 0 30px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  transition: transform 0.6s ease;
  z-index: 2;
}

.container.move-left .switch-panel {
  transform: translateX(-100%);
}

/* Form Login */
.login-form {
  width: 50%;
  padding: 40px;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(6px);
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: white;
  z-index: 1;
}

/* Form Sign Up */
.signup-form {
  position: absolute;
  right: 0;
  width: 50%;
  height: 100%;
  padding: 40px;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(6px);
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: white;
  transform: translateX(100%);
  transition: transform 0.6s ease;
  z-index: 1;
}

.container.move-left .signup-form {
  transform: translateX(0);
}

/* Form Forgot Password */
.forgot-form {
  position: absolute;
  left: -100%;
  width: 50%;
  height: 100%;
  padding: 40px;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(6px);
  display: flex;
  flex-direction: column;
  justify-content: center;
  color: white;
  transition: transform 0.6s ease;
  z-index: 1;
}

.container.forgot-active .forgot-form {
  transform: translateX(100%);
  z-index: 3;
}

.container.forgot-active .login-form,
.container.forgot-active .signup-form,
.container.forgot-active .switch-panel {
  opacity: 0;
  pointer-events: none;
}

input {
  padding: 10px;
  border-radius: 8px;
  border: none;
  margin-bottom: 15px;
  width: 100%;
}

button {
  padding: 10px;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
}

.login-btn {
  background-color: #66aba0;
  color: white;
}

.switch-btn {
  background-color: #2b2d42;
  color: white;
}

.gender {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.gender button {
  flex: 1;
  background: #5e4b8b;
  color: white;
}

.forgot-password-link {
  margin-top: 10px;
  text-align: center;
  color: #ffffff;
  font-size: 14px;
  text-decoration: underline;
  cursor: pointer;
}
