import { Route, Routes } from "react-router-dom";
import Home from "./src/Home";
import NavBar from "./src/components/NavBar";
import Login from "./src/pages/login"

import Productos from "./src/pages/Productos";
import CrearBebida from "./src/pages/crearBebida"
import GestionarBebidas from "./src/pages/gestionarBebidas"

import Bodegas from "./src/pages/Bodegas";
import CrearBodega from "./src/pages/crearBodega"
import GestionarBodegas from "./src/pages/gestionarBodegas"

import CrearTraspaso from "./src/pages/crearTraspaso"

import Footer from "./src/components/Footer";

const RouterApp = () => {
  return (
    <>
    <NavBar/>
      <Routes>
        <Route exact path="/" element={<Home />} />
        <Route path="/productos" element={<Productos/>} />
        <Route path="/login" element={<Login/>} />
        <Route path="/crear_bebida" element={<CrearBebida/>}/>
        <Route path="/gestion_de_bebidas" element={<GestionarBebidas/>}/>
        <Route path="/bodegas" element={<Bodegas/>} />
        <Route path="/crear_bodega" element={<CrearBodega/>}/>
        <Route path="/gestion_de_bodegas" element={<GestionarBodegas/>}/>
        <Route path="/crear_traspaso" element={<CrearTraspaso/>}/>

      </Routes>
      <Footer/>
    </>
  );
};
export default RouterApp;