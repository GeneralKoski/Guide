import Image from "next/image";
import React, { useEffect, useState } from "react";
import ChatSingola from "./Chatsingola";
import Preview from "./Preview";
import { RiCheckDoubleFill } from "react-icons/ri";
import { LateraleButton } from "./LateraleButton";
import { LateraleFilters } from "./LateraleFilters";

interface ChatData {
  icon: string;
  chat_name: string;
  last_message_content: string;
  seen: "yes" | "no";
  chat_id: string;
  last_message_sender_id: string;
  sent_at: string;
  message_type: string;
  chat_type: string;
}

interface Settings {
  setting_name: string;
  setting_value: string;
  user_id: string;
  username: string;
}

interface ID {
  id: string;
  username: string;
}

const Laterale: React.FC<ID> = ({ id, username }) => {
  const idUserAttuale = id;
  const nomeUserAttuale = username;

  // Gestisco il filterchat nella ricerca
  const [filteredChats, setFilteredChats] = useState<ChatData[]>([]); // Stato per le chat filtrate
  const [searchTerm, setSearchTerm] = useState<string>(""); // Stato per il termine di ricerca

  // Tiene conto della chat cliccata, da passare a <ChatSingola/> che con il settingetro crea la sua impaginazione
  const [selectedChat, setSelectedChat] = useState<string | null>(null);

  // Prende tutte le chat disponibili nel file chats.json
  const [users, setUsers] = useState<ChatData[]>([]); // Stato per memorizzare gli utenti dalla chiamata PHP
  useEffect(() => {
    fetch(`http://localhost:3000/selectAllChats.php?user_id=${idUserAttuale}`)
      .then((response) => response.json()) // Converto in json
      .then((data) => {
        console.log("Chat ricevute:", data); // Verifica i dati
        setUsers(data); // Memorizza i dati utenti
        setFilteredChats(data);
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  }, []);

  const [settings, setSettings] = useState<Settings[] | 0>(0);
  useEffect(() => {
    fetch(`http://localhost:3000/getUsersSettings.php?user_id=${idUserAttuale}`)
      .then((response) => response.json())
      .then((data) => {
        console.log("Settings degli Utenti:", data);
        setSettings(data);
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  }, []);

  const conferma_lettura = (id: string): string => {
    // Da cambiare il parametro passato user.chat_id, dovrebbe essere user.id
    if (settings === 0) return "yes";
    const setting = settings.find(
      (setting) =>
        setting.setting_name === "conferme_lettura" && setting.username === id
    );
    return setting && setting.setting_value === "no" ? "no" : "yes";
  };

  // Gestisco la chat selezionata e azzero il numero di messaggi da vedere
  const handleChatClick = (id: React.SetStateAction<string | null>) => {
    if (selectedChat === id) {
      setSelectedChat(null);
    } else {
      setSelectedChat(id);
      setUnseenMessages((prevState) => ({
        ...prevState,
        [String(id)]: 0,
      }));
    }
  };

  // Funzione per uscire dalla chat quando si preme "esc" sulla tastiera
  useEffect(() => {
    const handleKeyDown = (event: KeyboardEvent) => {
      if (event.key === "Escape") {
        setSelectedChat(null); // Deseleziona la chat
      }
    };

    document.addEventListener("keydown", handleKeyDown);
    return () => {
      document.removeEventListener("keydown", handleKeyDown);
    };
  }, []);

  // Faccio il fetch per ogni chat per i messaggi non visti
  const [unseenMessages, setUnseenMessages] = useState<{
    [key: string]: number;
  }>({});
  useEffect(() => {
    users.forEach((user) => {
      fetch(
        `http://localhost:3000/notSeenMessagesPerChat.php?chat_id=${user.chat_id}&user_id=${idUserAttuale}`
      )
        .then((response) => response.json())
        .then((data) => {
          setUnseenMessages((prevState) => ({
            ...prevState,
            [user.chat_id]: data,
          }));
        })
        .catch((error) => {
          console.error("Errore:", error);
        });
    });
  }, [users]);

  // Per filtrare tra le chat al variare dell'input
  // const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
  //   const searchValue = event.target.value.toLowerCase();
  //   setSearchTerm(searchValue);

  //   if (searchValue == "") {
  //     setFilteredChats(users);
  //   } else {
  //     const filtered = users.filter((user) =>
  //       user.chat_name.toLowerCase().includes(searchValue)
  //     );
  //     setFilteredChats(filtered);
  //   }
  // };

  // Funzione per ottenere le iniziali
  const getInitials = (name: string): string => {
    const words = name.split(" ");

    return words.map((word) => word[0].toUpperCase()).join("");
  };

  const chatButtons = [
    {
      src: "/images/nuovachat.png",
      alt: "nuova chat",
      title: "Nuova chat",
    },
    {
      src: "/images/trepunti.png",
      alt: "tre punti",
      title: "Tre punti",
    },
  ];

  const filters = [
    { filterName: "Tutte" },
    { filterName: "Da Leggere" },
    { filterName: "Preferiti" },
    { filterName: "Gruppi" },
  ];

  return (
    <>
      <div className="elenco">
        {/* Chat, nuova chat e tre punti */}
        <div className="sezionechat">
          <h4>Chat</h4>
          <ul>
            {chatButtons.map((btn) => {
              return (
                <LateraleButton src={btn.src} alt={btn.alt} title={btn.title} />
              );
            })}
          </ul>
        </div>
        {/* Input */}
        <div className="ricerca">
          <Image
            className="img-fluid lente"
            src="/images/lente.png"
            alt="lente"
            width={20}
            height={20}
          />
          <input
            type="text"
            placeholder="Cerca"
            value={searchTerm}
            // onChange={handleInputChange} // Gestisce il cambiamento di input
          />
        </div>
        {/* Filtri */}
        <div>
          <ul id="filtri">
            {filters.map((filter) => {
              return (
                <div
                  style={{ display: "inline" }}
                  onClick={() => alert(`Hai cliccato su ${filter.filterName}`)}
                >
                  <LateraleFilters filterName={filter.filterName} />
                </div>
              );
            })}
          </ul>
        </div>

        {/* Carico le chat */}
        <div className="lechat">
          {filteredChats.map((user) => (
            <div
              className="chat"
              key={user.last_message_sender_id}
              onClick={() => handleChatClick(user.chat_id)}
            >
              <Image
                className="img-fluid profilo"
                width={70}
                height={70}
                src={user.icon ? user.icon : "/images/default_icon.jpg"}
                alt={getInitials(user.chat_name)}
              />
              <div>
                <h4>{user.chat_name}</h4> <br />
                <p className="chat-message text-truncate">
                  {user.chat_type == "single" ? (
                    conferma_lettura(user.chat_name) == "yes" &&
                    conferma_lettura(nomeUserAttuale) == "yes" ? (
                      user.last_message_sender_id === idUserAttuale &&
                      user.seen === "yes" ? (
                        <RiCheckDoubleFill size={18} color="#007FFF" />
                      ) : user.last_message_sender_id === idUserAttuale &&
                        user.seen === "no" ? (
                        <RiCheckDoubleFill size={18} color="grey" />
                      ) : (
                        []
                      )
                    ) : user.last_message_sender_id === idUserAttuale ? (
                      <RiCheckDoubleFill size={18} color="grey" />
                    ) : (
                      []
                    )
                  ) : user.last_message_sender_id === idUserAttuale &&
                    user.seen === "yes" ? (
                    <RiCheckDoubleFill size={18} color="#007FFF" />
                  ) : user.last_message_sender_id === idUserAttuale &&
                    user.seen === "no" ? (
                    <RiCheckDoubleFill size={18} color="grey" />
                  ) : (
                    "User " + user.last_message_sender_id + ": "
                  )}
                  {user.message_type == "message" ? (
                    user.last_message_sender_id == idUserAttuale ? (
                      "Tu: " + user.last_message_content
                    ) : (
                      user.last_message_content
                    )
                  ) : (
                    <>
                      <img
                        src="/images/ImagePreview.jpg"
                        alt="Immagine"
                        style={{ height: 20, width: 20, borderRadius: 5 }}
                      />
                      <span>
                        {user.last_message_content != ""
                          ? " " + user.last_message_content
                          : " Foto"}
                      </span>
                    </>
                  )}
                </p>
              </div>
              <div>
                {user.last_message_sender_id !== idUserAttuale ? (
                  <span className="chat-time">
                    {user.sent_at.slice(11, 16)} <br />
                    <span
                      className={
                        unseenMessages[user.chat_id] !== 0 ? "chat-tosee" : ""
                      }
                    >
                      {unseenMessages[user.chat_id] !== 0
                        ? unseenMessages[user.chat_id]
                        : ""}
                    </span>
                  </span>
                ) : (
                  <span className="chat-time">
                    {user.sent_at.slice(11, 16)} <br />
                  </span>
                )}
              </div>
            </div>
          ))}
        </div>
      </div>
      {/* Booleano per mostrare o la preview o la chat singola */}
      {selectedChat ? (
        <div className="messaggi">
          {
            <ChatSingola
              selectedChat={selectedChat}
              id={idUserAttuale}
              username={nomeUserAttuale}
            />
          }
        </div>
      ) : (
        <div className="contenuto">
          <Preview />
        </div>
      )}
    </>
  );
};

export default Laterale;
