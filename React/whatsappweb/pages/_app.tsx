import LoginPage from "@/components/LoginPage";
import SideBar from "@/components/Sidebar";
import Laterale from "@/components/Laterale";
import React, { useState } from "react";
import "@/styles/theme.scss";

function MyApp() {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [id, setId] = useState<string>("");
  const [username, setUsername] = useState<string>("");

  const setUserData = (id: string, username: string) => {
    setId(id);
    setUsername(username);
  };

  return (
    <div className="app">
      {isAuthenticated ? (
        <>
          <SideBar
            setIsAuthenticated={setIsAuthenticated}
            id={id}
            username={username}
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
