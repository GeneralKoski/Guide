import Image from "next/image";

const Preview: React.FC = () => {
  return (
    <div className="contenuto">
      <img
        src="../images/scaricawa.png"
        alt="Download WhatsApp for Mac"
        className="immagine"
      />
      <h2>Scarica WhatsApp per Mac</h2>
      <p>
        Scaricando l'app per Mac potrai fare chiamate e avere un'esperienza di
        navigazione più veloce.
      </p>
      <button className="bottone-download">Scarica dall'App Store</button>
      <p className="crittografia">
        <Image
          className="img-fluid lucchetto"
          src="/images/lucchetto.png"
          alt="Lock"
          width={20}
          height={20}
        />
        I tuoi messaggi personali sono protetti dalla crittografia end-to-end
      </p>
    </div>
  );
};

export default Preview;
