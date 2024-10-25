import "@/styles/theme.scss";

import Laterale from "@/components/laterale";
import SideBar from "@/components/sidebar";

function MyApp() {
  return (
    <div className="app">
      <SideBar />
      <Laterale />
      {/* <Preview /> qui non serve perchè apro o questa o <ChatSingola /> in base al barametro booleano dichiarato in "laterale" */}
      {/* <ChatSingola />  */}
    </div>
  );
}

export default MyApp;
