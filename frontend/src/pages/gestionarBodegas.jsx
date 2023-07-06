// Estilo de pagina importado
import "../styles/gestionarBodegas.css";


// Paquetes y bibliotecas importados
import axios from "axios";
import Swal from "sweetalert2";

// Componentes especificos importados
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";

// Iconos importados desde "react-icons/.."
import { FaTrash } from "react-icons/fa";
import { AiFillEdit } from "react-icons/ai";

const gestionarBodegas = () => {
  // Seteo de bodegas
  const [bodegas, setBodegas] = useState([]);
  // Seteo de estado de modal de edicion
  const [showModal, setShowModal] = useState(false);
  // Seteo de bodega seleccionada para editar en modal
  const [bodegaSeleccionada, setBodegaSeleccionada] = useState({
    nombre: ""
  });

/*------------------------------ SOLICITUD "GET" PARA OBTENER BODEGAS ------------------------------*/
  const getBodegas = async () => {
    const response = await axios.get(
      "http://127.0.0.1:8000/api/bodega/viewAll"
    );
    setBodegas(response.data.bodegas);
  };

 /*------------------------------ SOLICITUD "PUT" PARA EDITAR BODEGA ------------------------------*/
 const onSubmit = async (e) => {
    // Evitar que se recargue la pagina al enviar solicitud
    e.preventDefault();
    try{
      // Solicitud "PUT" para editar bodega por los valores de "bodegaSeleccionada"
      const response = await axios.put('http://127.0.0.1:8000/api/bodega/update', bodegaSeleccionada);
      // Notificacion de exito al editar bodega
      if (response.status === 200) {
        Swal.fire({
          icon: 'success',
          title: 'Bodega editada con éxito',
          text: 'Se ha editado la bodega',
          confirmButtonText: 'Ok'
        });
      }
      setShowModal(false);
      setBodegaSeleccionada(null);
      getBodegas();
    }catch(error){
      // Variable para almacenar los mensajes de error
      let errorMessage = "";
      // Recorrer los mensajes de error para almacenarlos en la variable "errorMessage"
      Object.values(error.response.data.errors).forEach((values) => {
        errorMessage += values + "<br>" ;
      })
      // Notificacion de error al editar bodega
      Swal.fire({
        icon: 'error',
        title: 'Error al editar bodega',
        html: errorMessage,
        confirmButtonText: 'Ok'
      });

    }
 };

/*------------------------------ SOLICITUD "DELETE" PARA ELIMINAR BEBIDA -----------------------------*/
  const eliminarBodega = async (id) => {
    try {
      const response = await axios.delete("http://127.0.0.1:8000/api/bodega/delete", { data: { id } });
        // Notificacion de exito al eliminar bodega
        if (response.status === 200) {
            Swal.fire({
                icon: "success",
                title: "Bodega eliminada exitosamente",
                showConfirmButton: true,
                timer: 1500,
            });
            getBodegas();
        }
    }catch (error) {
        // Notificacion de error al eliminar bodega
        Swal.fire({
            icon: "error",
            title: "Error al eliminar bodega",
            text: "No se pudo eliminar la bodega",
        });
    }
  }

  // Funcion para mostrar cada bodega a la tabla de bodega
  const showBodegas = () => {
    return bodegas.map((bodega) => {
      return (
        <tr key={bodega.id}>
          <td>{bodega.nombre}</td>
          <td>
            <button title="Editar" onClick={()=> editarBodega(bodega)}> <AiFillEdit/> </button>
            <button title="Eliminar" onClick={()=> eliminarBodega(bodega.id)}> <FaTrash/> </button>
          </td>
        </tr>
      );
    });
  };

  // Funcion para habilitar y visualizar el modal con los datos de la bodega seleccionada
  const editarBodega = (bodega) => {
    // Habilitar modal
    setShowModal(true);
    // Setear bodega seleccionada
    setBodegaSeleccionada(bodega);
  };

  // Obtencion de bodegas al cargar el componente de la pagina
  useEffect(() => {
    getBodegas();
  }, []);

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
        <div className="btn-bodega">
          <button><Link to={"/crear_bodega"}>Crear bodega</Link></button>
        </div>
      </div>

      {showModal && bodegaSeleccionada && (
        <div className="modal-bodega">
          <div className="modal-bodega--content">
            <h2>Editar bodega</h2>
            <label>Nombre</label>
            <input 
              type="text"
              name="nombre"
              defaultValue={bodegaSeleccionada.nombre}
              onChange={(e) => setBodegaSeleccionada({...bodegaSeleccionada, nombre: e.target.value})} 
            />

            <button className="btn-save-bodega" onClick={onSubmit}>Guardar</button>
            <button 
              className="btn-close-bodega"
              onClick={() =>{
                setBodegaSeleccionada(null);
                setShowModal(false);
              }}
            >
              Cancelar
            </button>

          </div>
        </div>
      )}


    </>
  );
};

export default gestionarBodegas;
