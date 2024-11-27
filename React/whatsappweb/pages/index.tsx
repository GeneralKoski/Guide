import LoginPage from "@/components/LoginPage";
import SideBar from "@/components/Sidebar";
import Laterale from "@/components/Laterale";
import { useState } from "react";
import { NextPage } from "next";
import Head from "next/head";

const Home: NextPage = () => {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [id, setId] = useState<string>("");
  const [username, setUsername] = useState<string>("");

  const setUserData = (id: string, username: string) => {
    setId(id);
    setUsername(username);
  };
  return (
    <div>
      <Head>
        <meta
          name="description"
          content="WhatsApp Web, web application for whatsapp to communicate with everyone, including friends, parents etc."
        />
      </Head>
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
    </div>
  );
};
export default Home;
