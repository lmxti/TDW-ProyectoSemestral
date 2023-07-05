import { useState, useEffect } from "react";
import "../styles/gestionarBebidas.css";


import axios from "axios";
import Swal from "sweetalert2";
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

  useEffect(() => {
    getBebidas();
  }, []);

  const getBebidas = async () => {
    const response = await axios.get(
      "http://127.0.0.1:8000/api/bebida/viewAll"
    );
    setBebidas(response.data.bebidas);
  };

  // Funcion para recorrer el array de bebidas y devolver elementos de tabla
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
    ));
  };

  const editarBebida = (bebida) => {
    setShowModal(true);
    setBebidaSeleccionada(bebida);
  };

  const onSubmit = async (e) => {
    e.preventDefault();


    try{
      const response = await axios.put('http://127.0.0.1:8000/api/bebida/update', bebidaSeleccionada);
      console.log(bebidaSeleccionada); 
      if (response.status === 200) {
        Swal.fire({
          icon: 'success',
          title: 'Bebida editada con éxito',
          text: 'Se ha editado la bebida',
          confirmButtonText: 'Ok'
        });
      } else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Algo salió mal!',
          confirmButtonText: 'Ok'
        });
      }
    } catch {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Algo salió mal!',
        confirmButtonText: 'Ok'
      });
    }
  }

  const eliminarBebida = async (id) => {
    await axios.delete("http://127.0.0.1:8000/api/bebida/delete", {
      data: { id },
    });
    getBebidas();
  };

  return (
    <>
      <div className="tabla-container">
        <table className="tabla-content">
          <tr>
            <th>Nombre</th>
            <th>Sabor</th>
            <th>Tamaño</th>
            <th>Opciones</th>
          </tr>
          {showBebidas()}
        </table>
      </div>

      {showModal && bebidaSeleccionada && (
        <div className="modal">
          <div className="modal-content">
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

            <label>Tamano</label>
            <input
              type="text"
              name="tamano"
              defaultValue={bebidaSeleccionada.tamano}
              onChange={ (e) => setBebidaSeleccionada({...bebidaSeleccionada, tamano: e.target.value})}
            />
          
            <button 
              className="btn-save" 
              onClick={ onSubmit }
            >
              Guardar
            </button>
            <button
              className="btn-close"
              onClick={() => {
                setShowModal(false);
                setBebidaSeleccionada(null);
              }}
            >
              Cerrar
            </button>

          </div>
        </div>
      )}
    </>
  );
};

export default gestionarBebidas;
