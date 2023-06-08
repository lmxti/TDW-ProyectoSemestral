import { Route, Routes } from "react-router-dom";
import Home from "./src/Home";
import NavBar from "./src/components/NavBar";
import Productos from "./src/pages/Productos";
import Login from "./src/pages/Login"

const RouterApp = () => {
  return (
    <>
    <NavBar/>
      <Routes>
        <Route exact path="/" element={<Home />} />
        <Route path="/productos" element={<Productos/>} />
        <Route path="/login" element={<Login/>} />
      </Routes>
    </>
  );
};
export default RouterApp;