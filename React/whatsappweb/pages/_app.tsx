import LoginPage from "@/components/LoginPage";
import SideBar from "@/components/Sidebar";
import Laterale from "@/components/Laterale";
import React, { useState } from "react";
import "@/styles/theme.scss";

function MyApp() {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [id, setId] = useState<string>("");
  const [username, setUsername] = useState<string>("");
  const [icon, setIcon] = useState<string>("");

  const setUserData = (id: string, username: string, icon: string) => {
    setId(id);
    setUsername(username);
    setIcon(icon);
  };

  return (
    <div className="app">
      {isAuthenticated ? (
        <>
          <SideBar
            setIsAuthenticated={setIsAuthenticated}
            id={id}
            username={username}
            icon={icon}
          />
          <Laterale id={id} username={username} />
        </>
      ) : (
        <LoginPage
          setIsAuthenticated={setIsAuthenticated}
          setUserData={setUserData}
        />
      )}
    </div>
  );
}

export default MyApp;
