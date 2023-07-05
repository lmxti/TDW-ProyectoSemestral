import React from 'react'
import './Footer.css'
import { Link } from 'react-router-dom'


const Footer = () => {
  return (
    <footer>
    <div class="footer">
      <p>&copy; 2023 Energy Store. Todos los derechos reservados.</p>
      <ul>
        <li>
        <Link to={"/"}>Inicio</Link>
        </li>
      </ul>
    </div>
  </footer>
  )
}

export default Footer