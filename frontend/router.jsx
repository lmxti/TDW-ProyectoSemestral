import { Route, Routes } from "react-router-dom";
import Home from "./src/Home";
import NavBar from "./src/components/NavBar";
import Productos from "./src/pages/Productos";
import Login from "./src/pages/login"
import Manage from "./src/pages/manage";
import CrearBebida from "./src/pages/crearBebida"
import CrearBodega from "./src/pages/crearBodega"
import Footer from "./src/components/Footer";

const RouterApp = () => {
  return (
    <>
    <NavBar/>
      <Routes>
        <Route exact path="/" element={<Home />} />
        <Route path="/productos" element={<Productos/>} />
        <Route path="/login" element={<Login/>} />
        <Route path="/manage" element={<Manage/>} />
        <Route path="/crear_bebida" element={<CrearBebida/>}/>
        <Route path="/crear_bodega" element={<CrearBodega/>}/>
      </Routes>
      <Footer/>
    </>
  );
};
export default RouterApp;