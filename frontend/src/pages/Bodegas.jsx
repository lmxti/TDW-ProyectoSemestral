import { useState, useEffect } from "react";

// Dependencias importadas
import axios from "axios";

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
    <>
        <p key={bodega.id}>{bodega.nombre}</p>
    </>
    );
  };

  return (
  <>
    {showBodegas()}
  </>
  )
};

export default Bodegas;
