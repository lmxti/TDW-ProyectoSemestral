// Estilo de pagina importado
import "../styles/gestionarBebidas.css";

// Paquetes y bibliotecas importados
import axios from "axios";
import Swal from "sweetalert2";

// Componentes especificos importados
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";

// Iconos importados desde "react-icons/.."
import { FaTrash } from "react-icons/fa";
import { AiFillEdit } from "react-icons/ai";

const gestionarBebidas = () => {
  // Seteo de bebidas
  const [bebidas, setBebidas] = useState([]);
  // Seteo de estado de modal de edicion
  const [showModal, setShowModal] = useState(false);
  // Seteo de bebida seleccionada para editar en modal
  const [bebidaSeleccionada, setBebidaSeleccionada] = useState({
    nombre: "",
    sabor: "",
    tamano: "",
  });

 /*------------------------------ SOLICITUD "GET" PARA OBTENER BEBIDAS ------------------------------*/
  const getBebidas = async () => {
    // Solitud "GET" para obtener todas las bebidas
    const response = await axios.get("http://127.0.0.1:8000/api/bebida/viewAll");
    // Asignar bebidas obtenidas a la variable de estado "bebidas"
    setBebidas(response.data.bebidas);
  };

 /*------------------------------ SOLICITUD "PUT" PARA EDITAR BEBIDA ------------------------------*/
  const onSubmit = async (e) => {
    // Evitar que se recargue la pagina al enviar solicitud
    e.preventDefault();
    try{
      // Solicitud "PUT" para editar bebida por los valores de "bebidaSeleccionada".
      const response = await axios.put('http://127.0.0.1:8000/api/bebida/update', bebidaSeleccionada);
      // Notificacion de exito al editar bebida
      if (response.status === 200) {
        Swal.fire({
          icon: 'success',
          title: 'Bebida editada con éxito',
          text: 'Se ha editado la bebida',
          confirmButtonText: 'Ok'
        });
      }
      setShowModal(false);
      setBebidaSeleccionada(null);
      getBebidas();
    } catch(error) {
      // Variable para almacenar los mensajes de error
      let errorMessage = "";
      // Recorrer los mensajes de error para almacenarlos en la variable "errorMessage"
      Object.values(error.response.data.errors).forEach((values) => {
        errorMessage += values + "<br>" ;
      })
      // Notificacion de error al editar bebida
      Swal.fire({
        icon: 'error',
        title: error.response.data.message,
        html: errorMessage,
        confirmButtonText: 'Ok'
      });
    };
  };

 /*------------------------------ SOLICITUD "DELETE" PARA ELIMINAR BEBIDA ------------------------------*/
  const eliminarBebida = async (id) => {
    try{
      const response = await axios.delete("http://127.0.0.1:8000/api/bebida/delete", {data: { id }} );
        // Notificacion de exito al eliminar bebida
        if(response.status === 200){
          Swal.fire({
            icon: 'success',
            title: 'Bebida eliminada con éxito',
            text: 'Se ha eliminado la bebida',
            confirmButtonText: 'Ok'
          });
          getBebidas();
        }
    }catch(error){
      // Notificacion de error al eliminar bebida
      Swal.fire({
        icon: 'error',
        title: 'Error al eliminar bebida',
        text: 'No se ha podido eliminar la bebida',
      })
    }
  }

  // Funcion para mostrar cada bebida a la tabla de bebidas
  const showBebidas = () => {
    return bebidas.map((bebida) => (
      <tr key={bebida.id}>
        <td>{bebida.nombre}</td>
        <td>{bebida.sabor}</td>
        <td>{bebida.tamano}</td>
        <td>
          <button title="Editar" onClick={() => editarBebida(bebida)}> <AiFillEdit/></button>
          <button title="Eliminar" onClick={() => eliminarBebida(bebida.id)}> <FaTrash/></button>
        </td>
      </tr>
    ))
  }

  // Funcion para habilitar y visualizar el modal con los datos de la bebida seleccionada para editar
  const editarBebida = (bebida) => {
    // Habilitar modal
    setShowModal(true);
    // Setear bebida seleccionada
    setBebidaSeleccionada(bebida);
  };

  // Obtencion de bebidas al cargar el componente de la pagina
  useEffect(() => {
    getBebidas();
  }, []);

  return (
    <>
      <div className="tabla-container">
        <h1>Gestion de bebidas</h1>
        <table className="tabla-content">
          <tr>
            <th>Nombre</th>
            <th>Sabor</th>
            <th>Tamaño</th>
            <th>Opciones</th>
          </tr>
          {showBebidas()}
        </table>

        {/* Seccion de botones bajo la tabla */}
        <div className="btn-bebida">
          <button><Link to={"/crear_bebida"}>Crear bebida</Link></button>
        </div>

      </div>

      {/* Componente modal para editar valores de un registro de bebida */}
      {showModal && bebidaSeleccionada && (
        <div className="modal-bebida">
          <div className="modal-bebida--content">
            <h2>Editar Bebida</h2>
            
            <label>Nombre</label>
            <input 
              type="text" 
              name="nombre"
              defaultValue={bebidaSeleccionada.nombre}
              onChange={ (e) => setBebidaSeleccionada({...bebidaSeleccionada, nombre: e.target.value})}
            />

            <label>Sabor</label>
            <input 
              type="text"
              name="sabor"
              defaultValue={bebidaSeleccionada.sabor} 
              onChange={ (e) => setBebidaSeleccionada({...bebidaSeleccionada, sabor: e.target.value})}
            />

            <label>Tamaño</label>
            <input
              type="text"
              name="tamano"
              defaultValue={bebidaSeleccionada.tamano}
              onChange={ (e) => setBebidaSeleccionada({...bebidaSeleccionada, tamano: e.target.value})}
            />
          
            <button className="btn-save-bebida" onClick={ onSubmit }>Guardar</button>
            <button 
              className="btn-close-bebida" 
              onClick={() => {
                setShowModal(false);
                setBebidaSeleccionada(null);
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

export default gestionarBebidas;
