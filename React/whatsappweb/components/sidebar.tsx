import Image from "next/image";
import React, { useState } from "react";

const SideBar: React.FC = () => {
  const [selectedIndex, setSelectedIndex] = useState<number>(0);
  const handleClick = (message: string, index: number) => {
    alert(message);
    setSelectedIndex(index);
  };
  return (
    <div className="containerside">
      <ul className="icon-group top-icons">
        <li className={`icone ${selectedIndex === 0 ? "selected" : ""}`}>
          <a href="#" onClick={() => handleClick("Hai cliccato Chat!", 0)}>
            <Image
              className="img-fluid inverso"
              src="/images/chat.png"
              alt="Chat"
              title="Chat"
              width={35}
              height={35}
            />
          </a>
        </li>
        <li className={`icone ${selectedIndex === 1 ? "selected" : ""}`}>
          <a href="#" onClick={() => handleClick("Hai cliccato Stato!", 1)}>
            <Image
              className="img-fluid inverso"
              src="/images/stato.png"
              alt="Stato"
              title="Stato"
              width={30}
              height={30}
            />
          </a>
        </li>
        <li className={`icone ${selectedIndex === 2 ? "selected" : ""}`}>
          <a
            href="#"
            onClick={() => handleClick("Hai cliccato Canali!", 2)}
            title="Stato"
          >
            <Image
              className="img-fluid inverso"
              src="/images/canali.png"
              alt="Canali"
              title="Canali"
              width={35}
              height={35}
            />
          </a>
        </li>
        <li className={`icone ${selectedIndex === 3 ? "selected" : ""}`}>
          <a
            href="#"
            onClick={() => handleClick("Hai cliccato Community!", 3)}
            title="Stato"
          >
            <Image
              className="img-fluid inverso"
              src="/images/community.png"
              alt="Community"
              title="Community"
              width={35}
              height={35}
            />
          </a>
        </li>
      </ul>
      <ul className="basso">
        <li className={`icone ${selectedIndex === 4 ? "selected" : ""}`}>
          <a
            href="#"
            onClick={() => handleClick("Hai cliccato Impostazioni!", 4)}
            title="Stato"
          >
            <Image
              className="img-fluid inverso"
              src="/images/impostazioni.png"
              alt="Impostazioni"
              title="Impostazioni"
              width={30}
              height={30}
            />
          </a>
        </li>
        <li className={`icone ${selectedIndex === 5 ? "selected" : ""}`}>
          <a
            href="#"
            onClick={() => handleClick("Hai cliccato Profilo!", 5)}
            title="Stato"
          >
            <Image
              className="img-fluid"
              src="/images/profilo.png"
              title="Profilo"
              alt="Profilo"
              width={30}
              height={30}
            />
          </a>
        </li>
      </ul>
    </div>
  );
};

export default SideBar;
