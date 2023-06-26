import React, { useState } from "react";
import "../styles/crearBebida.css";
import Bebida from "../assets/bebida.png";

const crearBebida = () => {

    const [sabor, setSabor] = React.useState("");

    const handleSaborChange = (event) => {
      setSabor(event.target.value);
      updateLiquidColor(event.target.value);
    };

    const updateLiquidColor = (saborValue) => {
      const liquid = document.querySelector(".liquid");
      liquid.style.background = getColorBySabor(saborValue);
    };

    const getColorBySabor = (saborValue) => {
      if (saborValue === "Naranja" || saborValue === "naranja") {
        return "orange";
      } else if (saborValue === "Cola" || saborValue === "cola") {
        return "#413022";
      } else if (saborValue === "Lima" || saborValue === "lima" || saborValue === "Limon" || saborValue === "limon") {
        return "#b4e41c";
      } else if (saborValue === "Uva" || saborValue === "uva") {
        return "#6b0f9c";
      }
      // Si no hay una coincidencia específica, puedes devolver un color predeterminado
      return "#41c1fb";
    };


  return (
    <>
      <div className="crear-container">

        <div className="crear-content box-content">
          <form className="crear-form">
            <h1>Crear una bebida</h1>
            <input type="text" placeholder="Nombre" required />
            <input
                type="text" 
                id="saborInput"
                placeholder="Sabor"
                onChange={handleSaborChange}
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
