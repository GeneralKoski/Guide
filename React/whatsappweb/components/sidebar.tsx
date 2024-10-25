import React, { useState } from "react";
import { SidebarButton } from "./SidebarButton";

const SideBar: React.FC = () => {
  const [selectedId, setSelectedId] = useState<string>("chat");

  const handleClick = (message: string, id: string) => {
    setSelectedId(id);
  };

  const topItems = [
    { id: "chat", icon: "/images/chat.png" },
    { id: "stato", icon: "/images/stato.png" },
    { id: "canali", icon: "/images/canali.png" },
    { id: "community", icon: "/images/community.png" },
  ];

  const bottomItems = [
    { id: "impostazioni", icon: "/images/impostazioni.png" },
    { id: "profilo", icon: "/images/profilo.png" },
  ];

  return (
    <div className="containerside">
      <ul className="icon-group top-icons">
        {topItems.map((item, index) => {
          return (
            <SidebarButton
              id={item.id}
              icon={item.icon}
              selected={selectedId === item.id}
              onClick={(index) => handleClick("Hai cliccato Chat!", index)}
            >
              <div>asd</div>
            </SidebarButton>
          );
        })}
      </ul>

      <ul className="basso">
        {bottomItems.map((item, index) => {
          return (
            <SidebarButton
              id={item.id}
              icon={item.icon}
              selected={selectedId === item.id}
              onClick={(index) => handleClick("Hai cliccato Chat!", index)}
            />
          );
        })}
      </ul>
    </div>
  );
};

export default SideBar;
