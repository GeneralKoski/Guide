import React, { useState } from "react";
import "@/styles/theme.scss";
import SideBar from "@/components/Sidebar";
import Laterale from "@/components/Laterale";
import LoginPage from "@/components/LoginPage";

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
          <SideBar id={id} username={username} />
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
