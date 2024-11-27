import React, { useEffect, useState } from "react";
import { SidebarButton } from "./SidebarButton";

interface ID {
  setIsAuthenticated: (value: boolean) => void;
  id: string;
  username: string;
}
const SideBar: React.FC<ID> = ({ setIsAuthenticated, id, username }) => {
  const idUserAttuale = id;
  const nomeUserAttuale = username;
  const [selectedId, setSelectedId] = useState<string>("chat");

  const handleClick = (id: string) => {
    if (id === "logout") {
      alert(`Hai effettuato il ${id}`);
      setIsAuthenticated(false);
    } else {
      alert(`Hai cliccato ${id}`);
      setSelectedId(id);
    }
  };

  const [pfp, setPfp] = useState<string>("/images/default_icon.jpg");
  useEffect(() => {
    fetch(
      `http://localhost:3000/getLoggedUserpfp.php?user_id="${idUserAttuale}"`
    )
      .then((response) => response.text())
      .then((data) => {
        setPfp(data ? data : "/images/default_icon.jpg");
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  }, [idUserAttuale]);

  const topItems = [
    { id: "chat", icon: "/images/chat.png", alt: "chat", title: "Chat" },
    { id: "stato", icon: "/images/stato.png", alt: "stato", title: "Stato" },
    {
      id: "canali",
      icon: "/images/canali.png",
      alt: "canali",
      title: "Canali",
    },
    {
      id: "community",
      icon: "/images/community.png",
      alt: "community",
      title: "Community",
    },
  ];

  const bottomItems = [
    {
      id: "impostazioni",
      icon: "/images/impostazioni.png",
      alt: "impostazioni",
      title: "Impostzioni",
    },
    {
      id: "profilo",
      icon: pfp,
      alt: "profilo",
      title: nomeUserAttuale || "Profilo",
    },
    {
      id: "logout",
      icon: "/images/logout.png",
      alt: "logout",
      title: "Logout",
    },
  ];

  return (
    <div className="containerside">
      <ul className="icon-group">
        {topItems.map((item) => {
          return (
            <SidebarButton
              key={item.id}
              id={item.id}
              icon={item.icon}
              alt={item.alt}
              title={item.title}
              selected={selectedId === item.id}
              onClick={(id) => handleClick(id)}
            ></SidebarButton>
          );
        })}
      </ul>

      <ul className="icon-group basso">
        {bottomItems.map((item) => {
          return (
            <SidebarButton
              key={item.id}
              id={item.id}
              icon={item.icon}
              alt={item.alt}
              title={item.title}
              selected={selectedId === item.id}
              onClick={(id) => handleClick(id)}
              className={item.id == "profilo" ? "profile-image" : ""} // Passa la classe per l'immagine del profilo
            />
          );
        })}
      </ul>
    </div>
  );
};

export default SideBar;
