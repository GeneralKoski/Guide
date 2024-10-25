import Image from "next/image";
import React, { useEffect, useState } from "react";
import ChatSingola from "./chatsingola";
import Preview from "./preview";
import { RiCheckDoubleFill } from "react-icons/ri";
import { LateraleButton } from "./LateraleButton";
import { LateraleFilters } from "./LateraleFilters";

interface Message {
  type: "mio" | "altri" | "nessuno";
  content: string;
  time: string;
}

interface ChatData {
  icon: string;
  name: string;
  messages: Message[];
  access: string;
}

const Laterale: React.FC = () => {
  // Prende tutte le chat disponibili nel file chats.json
  const [chats, setChats] = useState<ChatData[]>([]);
  const [filteredChats, setFilteredChats] = useState<ChatData[]>([]); // Stato per le chat filtrate
  const [searchTerm, setSearchTerm] = useState<string>(""); // Stato per il termine di ricerca

  // Gestione dell'errore, non obbligatorio
  const [error, setError] = useState<string | null>(null);

  // Tiene conto della chat cliccata, da passare a <ChatSingola/> che con il parametro crea la sua impaginazione
  const [selectedChat, setSelectedChat] = useState<ChatData | null>(null);

  // Funzione per cambiare l'orario in minuti per aiutare l'ordine delle chat in descrescente
  const parseTimeToMinutes = (time: string): number => {
    const [hours, minutes] = time.split(":").map(Number);
    return hours * 60 + minutes;
  };

  // Caricare i dati dal file .json
  useEffect(() => {
    fetch("chats.json")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Errore nel caricamento del file JSON");
        }
        return response.json();
      })
      .then((data) => {
        if (Array.isArray(data)) {
          // Ordino i dati per orario dell'ultimo messaggio
          const sortedData = data.sort((a, b) => {
            const lastMessageA = a.messages[a.messages.length - 1];
            const lastMessageB = b.messages[b.messages.length - 1];
            return (
              parseTimeToMinutes(lastMessageB.time) -
              parseTimeToMinutes(lastMessageA.time)
            );
          });
          setChats(sortedData);
          setFilteredChats(sortedData); // Inizialmente, nessun filtro
        } else {
          throw new Error("Il formato del file JSON non è un array");
        }
      })
      .catch((error) => setError(error.message));
  }, []);
  if (error) {
    return <div>Errore: {error}</div>;
  }

  // Funzione per gestire il click sulla chat e selezionare la chat specifica
  const handleChatClick = (chat: ChatData) => {
    if (selectedChat?.name === chat.name) {
      setSelectedChat(null);
    } else {
      setSelectedChat(chat); // Imposta la chat selezionata
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

  // Funzione per gestire il cambiamento dell'input e filtrare le chat
  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const term = e.target.value.toLowerCase();
    setSearchTerm(term);

    if (term === "") {
      setFilteredChats(chats); // Mostra tutte le chat se il campo è vuoto
    } else {
      const filtered = chats.filter((chat) => {
        const matchName = chat.name.toLowerCase().includes(term);
        const matchMessage = chat.messages.some((message) =>
          message.content.toLowerCase().includes(term)
        );
        return matchName || matchMessage;
      });
      setFilteredChats(filtered); // Aggiorna le chat filtrate
    }
  };

  if (error) {
    return <div>Errore: {error}</div>;
  }

  const chatButtons = [
    {
      id: "nuovachat",
      src: "/images/nuovachat.png",
      alt: "nuova chat",
      title: "Nuova chat",
    },
    {
      id: "trepunti",
      src: "/images/trepunti.png",
      alt: "tre punti",
      title: "Tre punti",
    },
  ];

  const Filters = [
    { id: "tutte", filterName: "Tutte" },
    { id: "daleggere", filterName: "Da_Leggere" },
    { id: "preferiti", filterName: "Preferiti" },
    { id: "gruppi", filterName: "Gruppi" },
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
                <LateraleButton
                  id={btn.id}
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
            type="text"
            placeholder="Cerca"
            value={searchTerm}
            onChange={handleInputChange} // Gestisce il cambiamento di input
          />
        </div>

        {/* Filtri */}
        <div>
          <ul id="filtri">
            {Filters.map((filter) => {
              return (
                <LateraleFilters
                  id={filter.id}
                  filterName={filter.filterName}
                />
              );
            })}
          </ul>
        </div>

        {/* Tutte le chat filtrate */}
        <div className="lechat">
          {filteredChats.map((chat) => (
            <div
              className="chat"
              key={chat.name}
              onClick={() => handleChatClick(chat)} // Passa la chat selezionata alla funzione che a sua volta compie altre azioni
            >
              <Image
                className="img-fluid profilo"
                src={chat.icon}
                alt={chat.name}
                width={70}
                height={70}
              />
              <div>
                <h4>{chat.name}</h4> <br />
                <p className="chat-message text-truncate">
                  {chat.messages[chat.messages.length - 1].type === "mio" ? (
                    <RiCheckDoubleFill size={18} color="#007FFF" />
                  ) : (
                    []
                  )}
                  {chat.messages[chat.messages.length - 1].content}
                </p>
              </div>

              <span className="chat-time">
                {chat.messages[chat.messages.length - 1].time}
              </span>
            </div>
          ))}
        </div>
      </div>

      {/* Booleano per mostrare o la preview o la chat singola */}
      {selectedChat ? (
        <div className="messaggi">{<ChatSingola chat={selectedChat} />}</div>
      ) : (
        <div className="contenuto">
          <Preview />
        </div>
      )}
    </>
  );
};

export default Laterale;
