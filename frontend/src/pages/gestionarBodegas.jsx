import { useState, useEffect } from "react";
import axios from "axios";

import Swal from "sweetalert2";
import { FaTrash } from "react-icons/fa";
import { AiFillEdit } from "react-icons/ai";

import "../styles/gestionarBodegas.css";

const gestionarBodegas = () => {
  const [bodegas, setBodegas] = useState([]);

  useEffect(() => {
    getBodegas();
  }, []);

  const getBodegas = async () => {
    const response = await axios.get(
      "http://127.0.0.1:8000/api/bodega/viewAll"
    );
    setBodegas(response.data.bodegas);
  };

  const showBodegas = () => {
    return bodegas.map((bodega) => {
      return (
        <tr key={bodega.id}>
          <td>{bodega.nombre}</td>
          <td>
            <button title="Editar"> <AiFillEdit/> </button>
            <button title="Eliminar" onClick={()=> eliminarBodega(bodega.id)}> <FaTrash/> </button>
          </td>
        </tr>
      );
    });
  };

  const eliminarBodega = async (id) => {
    try {
      const response = await axios.delete("http://127.0.0.1:8000/api/bodega/delete", {
        data: { id },
      });
        if (response.status === 200) {
            Swal.fire({
                icon: "success",
                title: "Bodega eliminada exitosamente",
                showConfirmButton: false,
                timer: 1500,
            });
            getBodegas();
        }
    }catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error al eliminar bodega",
            text: "No se pudo eliminar la bodega",
        });
    }
  }
  return (
    <>
      <div className="tabla-bodegas--container">
        <h1>Gestion de bodegas</h1>
        <table className="tabla-bodegas--content">
          <tr>
            <th>Nombre</th>
            <th>Opciones</th>
          </tr>
          {showBodegas()}
        </table>
      </div>
    </>
  );
};

export default gestionarBodegas;
