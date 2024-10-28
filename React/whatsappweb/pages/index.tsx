import Laterale from "@/components/Laterale";
import SideBar from "@/components/Sidebar";
import { NextPage } from "next";
import Head from "next/head";

const Home: NextPage = () => {
  return (
    <div>
      <Head>
        <meta
          name="description"
          content="WhatsApp Web, web application for whatsapp to communicate with everyone, including friends, parents etc."
        />
      </Head>
      <SideBar />
      <Laterale />
    </div>
  );
};
export default Home;
