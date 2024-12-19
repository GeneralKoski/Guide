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
  token: string;
}

const Laterale: React.FC<ID> = ({ id, username, token }) => {
  const idUserAttuale = id;
  const nomeUserAttuale = username;
  const tokenUserAttuale = token;
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  // Gestisco il filterchat nella ricerca
  const [filteredChats, setFilteredChats] = useState<ChatData[]>([]); // Stato per le chat filtrate
  const [searchTerm, setSearchTerm] = useState<string>(""); // Stato per il termine di ricerca

  // Tiene conto della chat cliccata, da passare a <ChatSingola/> che con il settingetro crea la sua impaginazione
  const [selectedChat, setSelectedChat] = useState<string | null>(null);
  const [selectedChatType, setSelectedChatType] = useState<string | null>(null);

  // Prende tutte le chat disponibili
  const [users, setUsers] = useState<ChatData[]>([]); // Stato per memorizzare gli utenti dalla chiamata PHP
  const selectAllChats = () => {
    fetch(`http://localhost:8000/api/select-all-chats`, {
      method: "GET",
      headers: {
        Authorization: `Bearer ${tokenUserAttuale}`,
      },
    })
      .then((response) => response.json()) // Converto in json
      .then((data) => {
        console.log("Chat ricevute:", data); // Verifica i dati
        setUsers(data); // Memorizza i dati utenti
        setFilteredChats(data);
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  };

  useEffect(() => {
    selectAllChats();
  }, []);

  const [settings, setSettings] = useState<Settings[] | 0>(0);
  useEffect(() => {
    fetch(
      `http://localhost:8000/api/get-users-settings?user_id=${idUserAttuale}`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${tokenUserAttuale}`,
        },
      }
    )
      .then((response) => response.json())
      .then((data) => {
        console.log("Settings degli Utenti:", data);
        setSettings(data);
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  }, []);

  // Gestisco la chat selezionata e azzero il numero di messaggi da vedere
  const handleChatClick = (id: string, type: string) => {
    if (selectedChat === id) {
      setSelectedChat(null);
      setSelectedChatType(null);
    } else {
      setSelectedChat(id);
      setSelectedChatType(type);

      findUnseen(id) == 0
        ? ""
        : // Aggiorna lo stato dei messaggi non letti nel frontend
          "";

      // Funzione per aggiornare il db al click della chat
      findUnseen(id) == 0
        ? ""
        : fetch("http://localhost:8000/api/update-seen-messages", {
            method: "PUT",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              Accept: "application/json",
              Authorization: `Bearer ${tokenUserAttuale}`,
            },
            body: new URLSearchParams({
              chat_id: id,
              chat_type: type,
            }),
          })
            .then((response) => response.json())
            .then((data) => {
              console.log(data.message);
              setUnseenMessages((prevUnseen) =>
                prevUnseen.map((chat) =>
                  chat.chat_id === id ? { ...chat, non_letti: "0" } : chat
                )
              );
            })
            .catch((error) => {
              console.error("Errore:", error);
            });
    }
  };

  // Faccio una fetch singola per avere un array con tutti i valori dei messaggi non visti per chat
  const [unseenMessages, setUnseenMessages] = useState<
    {
      chat_id: string;
      non_letti: string;
    }[]
  >([]);
  useEffect(() => {
    fetch(
      `http://localhost:8000/api/not-seen-messages-per-chat?user_id=${idUserAttuale}`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${tokenUserAttuale}`,
        },
      }
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.length > 0) {
          console.log("Not seen messages: ", data);
          setUnseenMessages(data);
        } else {
          console.log("Tutti i messaggi sono stati visualizzati");
        }
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  }, []);

  const findUnseen = (chatID: string) => {
    const notRead = unseenMessages.find((msg) => msg.chat_id == chatID);
    return notRead ? notRead.non_letti : 0;
  };

  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const searchValue = event.target.value.toLowerCase();
    setSearchTerm(searchValue);

    const filtered = users.filter((user) =>
      user.chat_name
        ? user.chat_name.toLowerCase().includes(searchValue)
        : false
    );
    setFilteredChats(filtered);
  };

  const conferma_lettura = (username: string) => {
    if (settings === 0) {
      return true;
    }
    const setting = settings.find(
      (setting) =>
        setting.setting_name === "conferme_lettura" &&
        setting.username === username
    );
    return setting && setting.setting_value === "yes";
  };

  // Funzione per ottenere le iniziali
  const getInitials = (name: string): string => {
    const words = name.split(" ");

    return words.map((word) => word[0].toUpperCase()).join("");
  };

  const isNotToday = (sentAt: string): string => {
    const messageDate = new Date(sentAt);
    const todayMidnight = new Date(today);

    const yesterdayMidnight = new Date(todayMidnight);
    yesterdayMidnight.setDate(todayMidnight.getDate() - 1);

    if (messageDate >= yesterdayMidnight && messageDate < todayMidnight) {
      return "ieri";
    } else if (messageDate <= yesterdayMidnight) {
      return "prima";
    }
    return "";
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

  return (
    <>
      <div className="elenco">
        {/* Chat, nuova chat e tre punti */}
        <div className="sezionechat">
          <h4>Chat</h4>
          <ul>
            {chatButtons.map((btn, id) => {
              return (
                <LateraleButton
                  key={id}
                  src={btn.src}
                  alt={btn.alt}
                  title={btn.title}
                />
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
            id="filtro"
            type="text"
            placeholder="Cerca"
            value={searchTerm}
            onChange={handleInputChange} // Gestisce il cambiamento di input
          />
        </div>
        {/* Filtri */}
        <div>
          <ul id="filtri">
            {filters.map((filter, id) => {
              return (
                <li
                  key={id}
                  style={{ display: "inline" }}
                  onClick={() => alert(`Hai cliccato su ${filter.filterName}`)}
                >
                  <LateraleFilters filterName={filter.filterName} />
                </li>
              );
            })}
          </ul>
        </div>

        {/* Carico le chat */}
        <div className="lechat">
          {filteredChats.map((user) => (
            <div
              className="chat"
              key={user.chat_id}
              onClick={() => handleChatClick(user.chat_id, user.chat_type)}
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
                  {user.last_message_sender_id === idUserAttuale ? (
                    conferma_lettura(nomeUserAttuale) &&
                    conferma_lettura(user.chat_name) &&
                    user.seen === "yes" ? (
                      <RiCheckDoubleFill size={18} color="#007FFF" />
                    ) : (
                      <RiCheckDoubleFill size={18} color="grey" />
                    )
                  ) : (
                    user.chat_type == "group" &&
                    user.last_message_sender_id !== idUserAttuale &&
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
                        {user.last_message_content == ""
                          ? " Foto"
                          : " " + user.last_message_content}
                      </span>
                    </>
                  )}
                </p>
              </div>
              <div>
                <span className="chat-time">
                  {isNotToday(user.sent_at) == "ieri"
                    ? "ieri"
                    : isNotToday(user.sent_at) == "prima"
                    ? user.sent_at.slice(0, 10)
                    : user.sent_at.slice(11, 16)}
                  <br />
                  {user.last_message_sender_id !== idUserAttuale ? (
                    <span
                      className={
                        findUnseen(user.chat_id) != "0" ? "chat-tosee" : ""
                      }
                    >
                      {findUnseen(user.chat_id) != "0"
                        ? findUnseen(user.chat_id)
                        : ""}
                    </span>
                  ) : (
                    ""
                  )}
                </span>
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
              selectedChatType={selectedChatType}
              id={idUserAttuale}
              username={nomeUserAttuale}
              token={token}
              onMessageInsert={selectAllChats}
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
