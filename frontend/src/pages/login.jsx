import React, { useState } from 'react';
import "../styles/Login.css";
import LoginImage from "../assets/login.png";

export default function Login() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    // Aquí puedes incluir la lógica de autenticación o enviar los datos al servidor
    console.log('Email:', email);
    console.log('Password:', password);
  };

  return (
      <section className='login-container'>
          <div className='login-content box-content'>
              <h1>Inicia sesion</h1>
                <form action="" className='login-form'>
                  <input type="email" name="" id="" placeholder="Ingresa tu Email" required />
                  <input type="password" name="" id="" placeholder="Ingresa tu contraseña" required />
                  <input type="submit" value="Enviar" className="login-button" />
                </form>
          </div>
          <div className='login-image box-content'>
            <img src={LoginImage} alt="" />
          </div>
      </section>
  );
}