import LoginPage from "@/components/LoginPage";
import SideBar from "@/components/Sidebar";
import Laterale from "@/components/Laterale";
import React, { useState } from "react";
import "@/styles/theme.scss";
import Head from "next/head";

function MyApp() {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [id, setId] = useState<string>("");
  const [username, setUsername] = useState<string>("");
  const [icon, setIcon] = useState<string>("");
  const [token, setToken] = useState<string>("");

  const setUserData = (
    id: string,
    username: string,
    icon: string,
    token: string
  ) => {
    setId(id);
    setUsername(username);
    setIcon(icon);
    setToken(token);
  };

  return (
    <>
      <Head>
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <title>WhatsApp - Trajkovski Martin</title>
      </Head>
      <div className="app">
        {isAuthenticated ? (
          <>
            <SideBar
              setIsAuthenticated={setIsAuthenticated}
              username={username}
              icon={icon}
              token={token}
            />
            <Laterale id={id} username={username} token={token} />
          </>
        ) : (
          <LoginPage
            setIsAuthenticated={setIsAuthenticated}
            setUserData={setUserData}
          />
        )}
      </div>
    </>
  );
}

export default MyApp;
