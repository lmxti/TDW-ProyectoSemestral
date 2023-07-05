import { useState, useEffect } from "react";
import "../styles/Productos.css";

// Dependencias importadas
import axios from "axios";

// Assets importados
import banner from "../assets/banner1.png";
import lata1 from "../assets/lata1.png";

 


export default function Productos() {
  const [productos, setProductos] = useState([]);
  
  useEffect(() => {
    getProductos();
  }, []);

  const getProductos = async () => {
    const response = await axios.get('http://127.0.0.1:8000/api/bebida/viewAll');
    setProductos(response.data.bebidas);
  };

  const showProductos = () => {
    return productos.map((producto) => (<>

      <div className="product">
        <img src={lata1} alt="" />
        <div className="product-information">
        <p className="product-name" key={producto.id}> {producto.nombre}</p>
        <p className="product-description" key={producto.id}> Sabor: {producto.sabor}</p>
        <p className="product-tamano" key={producto.id}> Tamano: {producto.tamano}</p>
        </div>
      </div>

    </>
    ))
  }

  return (
    <>
      <section className="product-base">
        <div className="product-container">
          <div className="banner">
            <img src={banner} alt="" />
          </div>
          {showProductos()}
        </div>
      </section>
    </>
  );
}
