import React from "react";
import "../styles/crearBodega.css";	
import Bodega from "../assets/personas.jpg";

const crearBodega = () => {
  return (
    <>
      <div className="crearBodega-container">

        <div className="crearBodega-content box-content">
          <form className="crearBodega-form">
            <h1>Crear una bodega</h1>
            <input type="text" placeholder="Nombre" />
            <input type="submit" value="Crear" className="crearBodega-button" />
          </form>
        </div>

        <div className="crearBodega-image box-content">
          <img src={Bodega} alt="" />
        </div>
      </div>
    </>
  );
};

export default crearBodega;
