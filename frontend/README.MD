### Inicializando el proyecto por primera vez
1. Montar el proyecto con `npm create vite@latest`
2. Seleccinar framework >> React
3. Seleccionar variante >> Javascript
4. Instalar las dependencias del proyecto con `npm install`
5. Inicializar la aplicacion en el servidor local con `npm run dev`

### Para tener multiples paginas
1. Para el enrutamiento entre paginas instalar react router DOM con `npm i react-router-dom`
2. Crear archivo "Home.jsx" en el directorio src, la cual sera la pagina principal ("/")
3. Crear carpeta "Pages" en el directorio src, donde se crearan las paginas ademas de la pagina home(inicio).
4. Crear un componente de barra de navegacion "NavBar" en el direcctorio src/components
5. Crear archivo "router.jsx" en el directorio principal

### Configuracion de archivo Routes.jsx
 
En la configuracion de este archivo se debe quedar algo asi, donde:

1. En la primera linea se debe importar los componentes `Route` y `Routes` del paquete "react-router-dom"
2. Luego se importa la barra de navegacion que creamos anteriormente.
3. Despues se debe importar las paginas que se tengan o se creen a futuro.
4. Dentro de routes se deben ir agregando el path de cada pagina con su respectivo elemento.

```jsx
    import { Route, Routes } from "react-router-dom";
    import NavBar from "./src/components/NavBar";
    import Home from "./src/Home";
    import New_Page from "./src/pages/New_Page";

    const RouterApp = () => {
    return (
        <>
            <NavBar/> 
            <Routes>
                <Route exact path="/" element={<Home />} />
                <Route path="/new_page" element={<New_page/>}>
            </Routes>
        </>
        )
    };

    export default RouterApp;

```

### Configuracion de componente "NavBar.jsx"

En el componente que utilizamos como barra de navegacion debe quedar algo asi, donde:

1. En la primera linea se importa `React` del paquete "react".
2. Luego se importa el componente `Link`del paquete "react-router-dom".
3. En lugar de la etiqueta `<a>` utilizamos `<Link>`.
4. Dentro de cada link se especifica una prop `to` que especifica la URL a la que debe redirigirse
5. Se especifica el texto que tendra cada enlace

```jsx
import React from "react";
import { Link } from "react-router-dom";

const NavBar = () => {
  return (
    <nav className="navbar">
      <ul>
        <Link to={"/"}>Inicio</Link>
        <Link to={"/enlace1"}>Enlace1</Link>
        <Link to={"/ènlace2"}>Enlace2</Link>
      </ul>
    </nav>
  );
};

export default NavBar;
```