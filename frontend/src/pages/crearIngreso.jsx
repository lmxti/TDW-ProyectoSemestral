import React from 'react'
import { useState, useEffect } from "react";

import axios from "axios";
import Swal from "sweetalert2";

const crearIngreso = () => {

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
                "http://127.0.0.1:8000/api/ingreso/create",
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
                    title: "Ingreso creado",
                    text: "El ingreso se ha creado correctamente",
                    confirmButtonText: "Ok",
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Ha ocurrido un error al crear el ingreso",
                confirmButtonText: "Ok",
            });
        }
    };

    return (
        <>
            <div className="crear-container">
                <div className="crear-content box-content">
                    <form className="crear-form">
                        <h1>Crear Ingreso</h1>
                        <input
                            type="text"
                            name="bodega_id"
                            placeholder="Bodega"
                            onChange={handleChange}
                            required
                        />

                        {cargamento.map((cargamento, index) => (
                            <div key={index}>
                                <input
                                    type="text"
                                    name={`bebida_id${index}`}
                                    placeholder="Bebida id"
                                    value={cargamento.bebida_id}
                                    onChange={(e)=>handleCargamentoChange(index, "bebida_id", e.target.value)}
                                    required
                                />

                                <input
                                    type="text"
                                    name={`bebida_nombre${index}`}
                                    placeholder="Bebida nombre"
                                    value={cargamento.bebida_nombre}
                                    onChange={(e)=>handleCargamentoChange(index, "bebida_nombre", e.target.value)}
                                    required
                                />

                                <input
                                    type="text"
                                    name={`cantidad${index}`}
                                    placeholder="Cantidad"
                                    value={cargamento.cantidad}
                                    onChange={(e)=>handleCargamentoChange(index, "cantidad", e.target.value)}
                                    required
                                />
                            </div>
                        ))}

                        <button type="button" onClick={agregarCargamento}>
                            Agregar cargamento
                        </button>

                        <input
                            type="submit"
                            value="Crear Ingreso"
                            className="crear-button"
                            onClick={onSubmit}
                        />
                    </form>
                </div>
            </div>
        </>
    )
}

export default crearIngreso