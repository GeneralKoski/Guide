import React, { useState } from "react";
import { SidebarButton } from "./SidebarButton";

const SideBar: React.FC = () => {
  const [selectedId, setSelectedId] = useState<string>("chat");

  const handleClick = (message: string, id: string) => {
    alert(message + " " + id);
    setSelectedId(id);
  };

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
      icon: "/images/profilo.png",
      alt: "profilo",
      title: "Profilo",
    },
  ];

  return (
    <div className="containerside">
      <ul className="icon-group top-icons">
        {topItems.map((item) => {
          return (
            <SidebarButton
              id={item.id}
              icon={item.icon}
              alt={item.alt}
              title={item.title}
              selected={selectedId === item.id}
              onClick={(id) => handleClick("Hai cliccato", id)}
            ></SidebarButton>
          );
        })}
      </ul>

      <ul className="basso">
        {bottomItems.map((item) => {
          return (
            <SidebarButton
              id={item.id}
              icon={item.icon}
              alt={item.alt}
              title={item.title}
              selected={selectedId === item.id}
              onClick={(index) => handleClick("Hai cliccato", index)}
            />
          );
        })}
      </ul>
    </div>
  );
};

export default SideBar;
