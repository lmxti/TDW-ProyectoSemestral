import React from "react";
import "../styles/crearBebida.css";
import Bebida from "../assets/bebida.png";

const crearBebida = () => {
  return (
    <>
      <div className="crear-container">

        <div className="crear-content box-content">
          <form className="crear-form">
            <h1>Crear una bebida</h1>
            <input type="text" placeholder="Nombre" required />
            <input
                type="text" 
                placeholder="Sabor"
                required
            />
            <input type="text" placeholder="Tamaño" required />
            <input type="submit" value="Crear" className="crear-button" />
          </form>
        </div>

        <div className="crear-image box-content">
          <img src={Bebida} alt="" />
        </div>

      </div>
    </>
  );
};

export default crearBebida;
