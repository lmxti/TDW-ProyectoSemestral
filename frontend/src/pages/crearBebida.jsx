import { useState, useEffect } from "react";
import "../styles/crearBebida.css";

// Dependencias importadas
import axios from "axios";
import Swal from "sweetalert2";

import Bebida from "../assets/bebida.png";

const crearBebida = () => {

  // Estado para almacenar los valores de los campos
  const [values, setValues] = useState({
    nombre: "",
    sabor: "",
    tamano: "",
  });

  // Funcion para actualizar los valores de los campos
  const handleChange = (event) => {
    setValues({
      ...values,
      [event.target.name]: event.target.value
    });
  };


  const onSubmit = async (e) => {
    e.preventDefault();
    try{
      const response = await axios.post('http://127.0.0.1:8000/api/bebida/create', values);
      if (response.status === 200) {
        Swal.fire({
          icon: 'success',
          title: 'Bebida creada con éxito',
          text: 'Se ha creado una nueva bebida',
          confirmButtonText: 'Ok'
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Algo salió mal!',
          confirmButtonText: 'Ok'
        })
      }
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Algo salió mal!',
        confirmButtonText: 'Ok'
      });
    }
  }


  return (
    <>
      <div className="crear-container">

        <div className="crear-content box-content">
          <form className="crear-form">
            <h1>Crear una bebida</h1>
            <input 
              type="text"
              name="nombre" 
              placeholder="Nombre" 
              value={values.nombre}
              onChange={handleChange}
              required 
            />

            <input
                type="text"
                name="sabor" 
                placeholder="Sabor"
                value={values.sabor}
                onChange={handleChange}
                required
            />
            <input 
                type="text" 
                name="tamano"
                placeholder="Tamaño"
                value={values.tamano}
                onChange={handleChange}                 
                required 
            />

            <input type="submit" value="Crear" className="crear-button" onClick={onSubmit} />
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
