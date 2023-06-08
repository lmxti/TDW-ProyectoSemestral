import React from "react";
import "./NavBar.css";
import logo from "../assets/logo.png";

import { Link } from "react-router-dom";


const NavBar = () => {
  return (
    <nav className="navbar">
      <Link to={"/"}>
        <img src={logo} className="logo" />
      </Link>

      <ul>
        <Link to={"/"}>Inicio</Link>
        <Link to={"/productos"}>Productos</Link>
        <Link to={"/login"}>Iniciar sesion</Link>
      </ul>
    </nav>
  );
};

export default NavBar;
