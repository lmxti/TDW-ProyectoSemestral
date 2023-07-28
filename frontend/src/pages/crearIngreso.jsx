import React from "react";
import { useState, useEffect } from "react";

import axios from "axios";
import Swal from "sweetalert2";
import "../styles/crearIngreso.css";

import {
  Icon,
  InputGroup,
  InputLeftAddon,
  InputRightAddon,
  Button,
} from "@chakra-ui/react";
import { IoStorefrontSharp, IoAddCircle, IoTrashBin } from "react-icons/io5";
import { LuCupSoda } from "react-icons/lu";

const crearIngreso = () => {
  // Seteo de bodegas
  const [bodegas, setBodegas] = useState([]);
  // Seteo de bebidas
  const [bebidas, setBebidas] = useState([]);
  // Seteo de bodega a crear ingreso
  const [bodega, setBodega] = useState({ bodega_id: "" });
  // Seteo de cargamento de ingreso
  const [cargamento, setCargamento] = useState([]);
  /*------------------------------ SOLICITUD "GET" PARA OBTENER BODEGAS ------------------------------*/
  const getBodegas = async () => {
    const response = await axios.get(
      "http://127.0.0.1:8000/api/bodega/viewAll"
    );
    setBodegas(response.data.bodegas);
  };
  /*------------------------------ SOLICITUD "GET" PARA OBTENER BEBIDAS ------------------------------*/
  const getBebidas = async () => {
    // Solitud "GET" para obtener todas las bebidas
    const response = await axios.get(
      "http://127.0.0.1:8000/api/bebida/viewAll"
    );
    // Asignar bebidas obtenidas a la variable de estado "bebidas"
    setBebidas(response.data.bebidas);
  };

  const handleBodegaChange = (e) => {
    setBodega({
      ...bodega,
      bodega_id: e.target.value,
    });
  };

  const agregarBebida = () => {
    setCargamento([
      ...cargamento,
      { bebida_id: "", bebida_nombre: "", cantidad: "" },
    ]);
  };

  const eliminarBebida = (index) => {
    const updatedCargamento = [...cargamento];
    updatedCargamento.splice(index, 1);
    setCargamento(updatedCargamento);
  };

  const handleCantidadChange = (index, e) => {
    const updatedCargamento = [...cargamento];
    updatedCargamento[index].cantidad = e.target.value;
    setCargamento(updatedCargamento);
  };

  const handleBebidaChange = (index, e) => {
    const updatedCargamento = [...cargamento];
    updatedCargamento[index].bebida_id = e.target.value;
    updatedCargamento[index].bebida_nombre = e.target.options[
      e.target.selectedIndex
    ].text
      .split("-")[0]
      .trim();
    // setTamano(bebidas[e.target.value-1].tamano);
    setCargamento(updatedCargamento);
  };

  // Funcion para enviar solicitud "POST" para crear ingreso con los datos ingresados
  const onSubmit = async (e) => {
    e.preventDefault();
    try {
      // Envio de solicitud "POST" para crear ingreso
      const response = await axios.post(
        "http://127.0.0.1:8000/api/ingreso/create",
        {
          ...bodega,
          cargamento: cargamento.map(
            ({ bebida_id, bebida_nombre, cantidad }) => ({
              bebida_id,
              bebida_nombre,
              cantidad,
            })
          ),
        }
      );
      // Alerta de exito al crear ingreso
      if (response.status === 200) {
        Swal.fire({
          icon: "success",
          title: "Ingreso creado",
          text: "El ingreso se ha creado correctamente",
          confirmButtonText: "Ok",
        });
      }
    } catch (error) {
      // Alerta de error al crear ingreso
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Ha ocurrido un error al crear el ingreso" + error,
        confirmButtonText: "Ok",
      });
    }
  };

  //Funcion para obtener bodegas al cargar la pagina
  useEffect(() => {
    getBodegas();
    getBebidas();
  }, []);

  return (
    <>
      <div className="crearIngreso-container">
        <div className="crearIngreso-content box-content">
          <h1>Crear Ingreso</h1>

          <form className="crearIngreso-form">
            <InputGroup bg={"white"}>
              <InputLeftAddon>
                <Icon as={IoStorefrontSharp} boxSize={20} width={50} />
              </InputLeftAddon>
              <select name="bodega_id" onChange={handleBodegaChange}>
                <option value="">Selecciona bodega</option>
                {bodegas.map((bodega) => (
                  <option value={bodega.id}>{bodega.nombre}</option>
                ))}
              </select>
            </InputGroup>

            {/* Inputs de cargamento id, nombre y cantidad */}
            {cargamento.map((item, index) => (
              <div key={index} className="item">
                <InputGroup bgColor={"white"}>
                  <InputLeftAddon>
                    <Icon as={LuCupSoda} boxSize={20} width={50} />
                  </InputLeftAddon>
                  <select
                    name="bebida_id"
                    onChange={(e) => handleBebidaChange(index, e)}
                    value={item.bebida_id}
                  >
                    <option value="">Selecciona bebida</option>
                    {bebidas.map((bebida) => (
                      <>
                        <option key={bebida.id} value={bebida.id}>
                          {bebida.nombre}-({bebida.tamano})
                        </option>
                      </>
                    ))}
                  </select>

                  <input
                    className="cantidad"
                    variant="flushed"
                    type="number"
                    min={1}
                    placeholder="Cantidad"
                    name="cantidad"
                    value={item.cantidad}
                    onChange={(e) => handleCantidadChange(index, e)}
                  />
                  <Button
                    className="btn-quitar"
                    leftIcon={<Icon as={IoTrashBin} boxSize={20} width={20}/> }
                    onClick={() => eliminarBebida(index)}
                  />
                  
                </InputGroup>
              </div>
            ))}

            <Button className="btn-add-bebida" onClick={agregarBebida} leftIcon={<IoAddCircle />}>
              Agregar producto
            </Button>
          </form>
          <div className="crearIngreso-btn-submit">
            <Button type="submit" onClick={onSubmit}>
              Crear Ingreso
            </Button>
          </div>
        </div>
      </div>
    </>
  );
};

export default crearIngreso;
