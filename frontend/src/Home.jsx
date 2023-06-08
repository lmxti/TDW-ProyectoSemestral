import './styles/Home.css';
import lata1 from "./assets/lata1.png";
import lata2 from "./assets/lata2.png";
import lata3 from "./assets/lata3.png";
import lata4 from "./assets/lata4.png";
import lata5 from "./assets/lata5.png";
import lata6 from "./assets/lata6.png";

import photo4 from "./assets/photo4.png";
import photo5 from "./assets/photo5.png";
import photo6 from "./assets/photo6.png";

function Home() {
  return (
    <>
      <section className="principal">
        <div className="contenido">
          <div className="textBox">
            <h2>
              Más que una bebida <br />
              Es <span>Energy Drink</span>
            </h2>
            <p>
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam,
              maiores ea. Tempora beatae aliquam, modi impedit architecto
              numquam id, dolores repudiandae quam fugit eos nisi eveniet.
              Aperiam in omnis voluptatem.
            </p>
            <a href="#">Ver más</a>
          </div>
        </div>
        <div>
          <img src={lata3} alt="Bebida en lata" />
        </div>
      </section>

      <section className="photos">
        <div className="photoGallery">
          <img src={photo4} alt="" />
          <img src={photo5} alt="" />
          <img src={photo6} alt="" />
        </div>
      </section>
      
      <section className="contact-container">
        <div className="contact-content">
            <div className="form-container">
                    <h3>Contactanos</h3>
                    <form action="" className="contact-form">
                        <input type="text" placeholder="Tu nombre" required/>
                        <input type="email" name="" id="" placeholder="Ingresa tu Email" required />
                        <textarea name="" id="" cols="30" rows="10" placeholder="Escribe tu mensaje aquí" required></textarea>
                        <input type="submit" value="Enviar" className="send-button" />
                    </form>
            </div>
        </div>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3543.1608508203994!2d-73.01420677923113!3d-36.822470410265325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9669b41835139b61%3A0x4c8fe1808ebdd3f9!2sUniversidad%20del%20B%C3%ADo-B%C3%ADo!5e1!3m2!1ses!2scl!4v1686063403696!5m2!1ses!2scl"
          loading="lazy"
        ></iframe>

      </section>

      <section className="aboutUs">
        <div className="content">
          <h2>Sobre nosotros</h2>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis
            vehicula enim in est condimentum, et fermentum dolor gravida.
            Phasellus ac faucibus lectus, a aliquam lorem.
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis
            vehicula enim in est condimentum, et fermentum dolor gravida.
            Phasellus ac faucibus lectus, a aliquam lorem.
          </p>
        </div>
      </section>
      <footer>
        <div class="footer">
          <p>&copy; 2023 Mi Sitio Web. Todos los derechos reservados.</p>
          <ul>
            <li>
              <a href="#">Inicio</a>
            </li>
            <li>
              <a href="#">Acerca de</a>
            </li>
            <li>
              <a href="#">Contacto</a>
            </li>
          </ul>
        </div>
      </footer>
    </>
  );
}

export default Home;

