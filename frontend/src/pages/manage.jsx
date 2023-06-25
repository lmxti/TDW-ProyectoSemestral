import "../styles/manage.css"
import React from 'react'
import bebidas from "../assets/bebidas.png";
import bodegas from "../assets/store.png";
import ingresos from "../assets/ingreso.png"
import traspasos from "../assets/traspaso.png";
import { Link } from "react-router-dom";

const manage = () => {
  return (
    <>
        <section className="management-base">
                <h1>Administracion</h1>
            <div className="management-container">

                <Link to={"/bebida"} className="management-item">
                    <img src={bebidas} alt="" />
                    <h1>Bebidas</h1>
                </Link>


                <div className="management-item">
                    <img src={bodegas} alt="" />
                    <h1>Bodegas</h1> 
                </div>

                <div className="management-item">
                    <img src={ingresos} alt="" />
                    <h1>Ingresos</h1>
                </div>

                <div className="management-item">
                <img src={traspasos} alt="" />
                    <h1>Traspasos</h1>
                </div>
            </div>
        </section>

    </>

  )
}

export default manage