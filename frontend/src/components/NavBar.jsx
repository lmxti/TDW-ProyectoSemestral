import React from "react";
import "./NavBar.css";
import logo from "../assets/logo.png";
import loginIcon from "../assets/loginIcon.png"

import { Link } from "react-router-dom";


const NavBar = () => {
  return (
    <nav>
      
       <Link to={"/"}>
            <img src={logo} alt="Logo inicio" />
       </Link>

      <ul className="contenedor-enlaces">
        <Link to={"/"}>Inicio</Link>
        <Link to={"/productos"} className="menu">Bebidas
          <ul className="submenu">
            <Link to={"/gestion_de_bebidas"}>Gestionar</Link>
          </ul>
        </Link>

        <Link to={"/bodegas"} className="menu">Bodegas
        <ul className="submenu">
            <Link to={"/gestion_de_bodegas"}>Gestionar</Link>
          </ul>
        </Link>

        <Link to={"/crear_traspaso"} className="menu">Traspaso
        </Link>
      </ul>

      <Link  title="Iniciar sesion" to={"/login"} className="loginIcon">
          <img   src={loginIcon} alt="Icono inicio sesion" />
      </Link>

    </nav>
  );
};

export default NavBar;