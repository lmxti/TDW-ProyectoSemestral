import { useState, useEffect } from "react";
import "../styles/crearBodega.css";	
import Bodega from "../assets/personas.jpg";

import axios from "axios";
import Swal from "sweetalert2";

const crearBodega = () => {


  const [values, setValues] = useState({
    nombre: "",
  });

  const handleChange = (event) => {
    setValues({
      ...values,
      [event.target.name]: event.target.value,
    });
  };

  const onSubmit = async (e) => {
    e.preventDefault();
    try{
      const response = await axios.post("http://127.0.0.1:8000/api/bodega/create", values);
      if(response.status === 200){
        Swal.fire({
          icon: "success",
          title: "Bodega creada con éxito",
          text: "Se ha creado una nueva bodega",
          confirmButtonText: "Ok",
        });
      }
    }catch(error){
      let errorMessage = "";
      Object.values(error.response.data.errors).forEach((values) => {
        errorMessage += values + "<br>" ;
      });
      Swal.fire({
        icon: "error",
        title: "Error",
        html: errorMessage,
        confirmButtonText: "Ok",
      });
    }
  };

  return (
    <>
      <div className="crearBodega-container">

        <div className="crearBodega-content box-content">
          <form className="crearBodega-form">
            <h1>Crear una bodega</h1>
            <input 
              type="text"
              name="nombre"
              onChange={handleChange}
              required
              placeholder="Nombre" />
            <input 
              type="submit" 
              value="Crear" 
              className="crearBodega-button"
              onClick={onSubmit}
             />
          </form>
        </div>

        <div className="crearBodega-image box-content">
          <img src={Bodega} alt="Imagen trabajadores" />
        </div>
      </div>
    </>
  );
};

export default crearBodega;
