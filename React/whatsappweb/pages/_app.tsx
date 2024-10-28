import React from "react";
import "@/styles/theme.scss";
import Laterale from "@/components/Laterale";
import SideBar from "@/components/Sidebar";

function MyApp() {
  return (
    <div className="app">
      <SideBar />
      <Laterale />
      {/* <Preview /> qui non serve perchè apro o questa o <ChatSingola /> in base al parametro booleano dichiarato in "laterale" */}
      {/* <ChatSingola />  */}
    </div>
  );
}

export default MyApp;
