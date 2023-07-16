import React from 'react'
import { useState, useEffect } from "react";

import axios from "axios";
import Swal from "sweetalert2";

const crearEgreso = () => {

    const [values, setValues] = useState({
        bodega_id: "",
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
            if (values.bodega_id.trim() === "") {
                Swal.fire({
                    icon: "error",
                    title: "Campos incompletos",
                    text: "Por favor completa todos los campos",
                    confirmButtonText: "Ok",
                });
                return;
            }

            const response = await axios.post(
                "http://127.0.0.1:8000/api/egreso/create",
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
                    title: "Egreso creado",
                    text: "El egreso se ha creado correctamente",
                    confirmButtonText: "Ok",
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Ha ocurrido un error al crear el egreso",
                confirmButtonText: "Ok",
            });
        }
    };

  return (
    <>
        <div className="crear-container">
            <div className="crear-content box-content">
                <form className="crear-form">
                    <h1>Crear Egreso</h1>
                    <input
                        type="text"
                        name="bodega_id"
                        placeholder="Bodega ID"
                        onChange={handleChange}
                        required
                    />

                    {cargamento.map((item, index) => (
                        <div key={index}>
                            <input
                                type="text"
                                name="bebida_id"
                                placeholder="Bebida ID"
                                onChange={(e) => handleCargamentoChange(index, "bebida_id", e.target.value)}
                                required
                            />

                            <input
                                type="text"
                                name="bebida_nombre"
                                placeholder="Bebida Nombre"
                                onChange={(e) => handleCargamentoChange(index, "bebida_nombre", e.target.value)}
                                required
                            />

                            <input
                                type="text"
                                name="cantidad"
                                placeholder="Cantidad"
                                onChange={(e) => handleCargamentoChange(index, "cantidad", e.target.value)}
                                required
                            />
                        </div>
                    ))}
                    <button type="button" onClick={agregarCargamento}>
                        Agregar cargamento
                    </button>

                    <input
                        type="submit"
                        value="Crear Egreso"
                        className="crear-button"
                        onClick={onSubmit}
                    />
                </form>
            </div>
        </div>
    </>
  )
}

export default crearEgreso