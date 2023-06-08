import "../styles/Productos.css";
import lata1 from "../assets/lata1.png";
import lata2 from "../assets/lata2.png";
import lata3 from "../assets/lata3.png";
import lata4 from "../assets/lata4.png";
import lata5 from "../assets/lata5.png";
import lata6 from "../assets/lata6.png";
import banner from "../assets/banner1.png";

export default function Productos() {
  return (
    <>
      <section className="product-base">
        <div className="product-container">

          <div className="banner">
            <img src={banner} alt="" />
          </div>

          <div className="product">
            <img src={lata1} alt="" />
            <div className="product-information">
              <p className="product-name">Bebida</p>
              <p className="product-description">Bebida energetica</p>
            </div>
          </div>

          <div className="product">
            <img src={lata2} alt="" />
            <div className="product-information">
              <p className="product-name">Bebida</p>
              <p className="product-description">Bebida energetica</p>
            </div>
          </div>

          <div className="product">
            <img src={lata3} alt="" />
            <div className="product-information">
              <p className="product-name">Bebida</p>
              <p className="product-description">Bebida energetica</p>
            </div>
          </div>

          <div className="product">
            <img src={lata4} alt="" />
            <div className="product-information">
              <p className="product-name">Bebida</p>
              <p className="product-description">Bebida energetica</p>
            </div>
          </div>

          <div className="product">
            <img src={lata5} alt="" />
            <div className="product-information">
              <p className="product-name">Bebida</p>
              <p className="product-description">Bebida energetica</p>
            </div>
          </div>

          <div className="product">
            <img src={lata6} alt="" />
            <div className="product-information">
              <p className="product-name">Bebida</p>
              <p className="product-description">Bebida energetica</p>
            </div>
          </div>
          
        </div>
      </section>
    </>
  );
}
