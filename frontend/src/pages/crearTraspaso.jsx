import React from 'react'
import { useState, useEffect } from "react";

import axios from "axios";
import Swal from "sweetalert2";

const crearTraspaso = () => {

  const [values, setValues] = useState({
    bodega_origen_id: "",
    bodega_destino_id: "",
  });

  const [cargamento, setCargamento] = useState([]);

  const handleChange = (event) => {
    setValues({
      ...values,
      [event.target.name]: event.target.value,
    });
  };

  const handleCargamentoChange = (index, field, value) => {
    const updatedCargamento = [...cargamento];
    updatedCargamento[index] = {
      ...updatedCargamento[index],
      [field]: value,
    };
    setCargamento(updatedCargamento);
  };

  const agregarCargamento = () => {
    setCargamento([...cargamento, { bebida_id: "", bebida_nombre: "", cantidad: "" }]);
  };

  const onSubmit = async (e) => {
    e.preventDefault();
    try {
      if (values.bodega_origen_id.trim() === "" || values.bodega_destino_id.trim() === "") {
        Swal.fire({
          icon: "error",
          title: "Campos incompletos",
          text: "Por favor completa todos los campos",
          confirmButtonText: "Ok",
        });
        return;
      }

      const response = await axios.post(
        "http://127.0.0.1:8000/api/traspaso/create",
        {
          ...values,
          cargamento: cargamento.map(({ bebida_id, bebida_nombre, cantidad }) => ({
            bebida_id,
            bebida_nombre,
            cantidad,
          })),
        }
      );

      if (response.status === 200) {
        Swal.fire({
          icon: "success",
          title: "Traspaso creado con éxito",
          text: "Se ha creado un nuevo traspaso",
          confirmButtonText: "Ok",
        });
      }
    } catch (error) {
      let errorMessage = "";
      Object.values(error.response.data.errors).forEach((values) => {
        errorMessage += values + "<br>";
      });

      Swal.fire({
        icon: "error",
        title: error.response.data.message,
        html: errorMessage,
        confirmButtonText: "Ok",
      });
    }
  };
  return (
    <>
      <div className="crear-container">
        <div className="crear-content box-content">
          <form className="crear-form">
            <h1>Crear traspaso</h1>
            <input
              type="text"
              name="bodega_origen_id"
              placeholder="Bodega origen"
              onChange={handleChange}
              required
            />

            <input
              type="text"
              name="bodega_destino_id"
              placeholder="Bodega destino"
              onChange={handleChange}
              required
            />

            {cargamento.map((cargamento, index) => (
              <div key={index}>
                <input
                  type="text"
                  name={`bebida_id_${index}`}
                  placeholder="Bebida id"
                  value={cargamento.bebida_id}
                  onChange={(event) => handleCargamentoChange(index, 'bebida_id', event.target.value)}
                  required
                />

                <input
                  type="text"
                  name={`bebida_nombre_${index}`}
                  placeholder="Bebida nombre"
                  value={cargamento.bebida_nombre}
                  onChange={(event) => handleCargamentoChange(index, 'bebida_nombre', event.target.value)}
                  required
                />

                <input
                  type="text"
                  name={`cantidad_${index}`}
                  placeholder="Cantidad"
                  value={cargamento.cantidad}
                  onChange={(event) => handleCargamentoChange(index, 'cantidad', event.target.value)}
                  required
                />
              </div>
            ))}

            <button type="button" onClick={agregarCargamento}>
              Agregar cargamento
            </button>

            <input
              type="submit"
              value="Crear traspaso"
              className="crear-button"
              onClick={onSubmit}
            />
          </form>
        </div>
      </div>
    </>
  )
}

export default crearTraspaso