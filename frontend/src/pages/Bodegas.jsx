import { useState, useEffect } from "react";

// Dependencias importadas
import axios from "axios";
import "../styles/Bodegas.css"
import banner from "../assets/banner2.jpeg";
import bodegaImagen from "../assets/bodegaImagen.jpeg"

const Bodegas = () => {
  const [bodegas, setBodegas] = useState([]);

  useEffect(() => {
    getBodegas();
  }, []);

  const getBodegas = async () => {
    const response = await axios.get("http://127.0.0.1:8000/api/bodega/viewAll");
    setBodegas(response.data.bodegas);
  };

  const showBodegas = () => {
    return bodegas.map((bodega) => 
    <div className="bodega">
      <img src={bodegaImagen} alt="xd" />
        <p className="bodega-name" key={bodega.id}>{bodega.nombre}</p>
    </div>
    );
  };

  return (
  <>
    <section className="bodegas-base">
      <div className="bodegas-container">
        <div className="banner-bodega">
          <img src={banner} alt="" />
        </div>
      {showBodegas()}
      </div>
    </section>
  </>
  )
};

export default Bodegas;
