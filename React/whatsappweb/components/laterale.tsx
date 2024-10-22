import Image from "next/image";
import React, { useEffect, useState } from "react";
import ChatSingola from "./chatsingola";
import Preview from "./preview";

interface Message {
  type: "mio" | "altri";
  content: string;
  time: string;
}

interface ChatData {
  icon: string;
  name: string;
  messages: Message[]; // Modifica per includere un array di messaggi
  access: string;
}

const Laterale: React.FC = () => {
  const [chats, setChats] = useState<ChatData[]>([]);
  const [error, setError] = useState<string | null>(null);
  const [a, setA] = useState<boolean>(true);
  const [selectedChat, setSelectedChat] = useState<ChatData | null>(null);

  // Funzione per cambiare l'orario in minuti per aiutare l'ordine in descrescente
  const parseTimeToMinutes = (time: string): number => {
    const [hours, minutes] = time.split(":").map(Number);
    return hours * 60 + minutes;
  };

  // Caricare i dati dal file .json
  useEffect(() => {
    fetch("/chats.json")
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
    setSelectedChat(chat); // Imposta la chat selezionata
    setA(false); // Mostra la chat singola e toglie la Preview
  };

  useEffect(() => {
    const handleKeyDown = (event: KeyboardEvent) => {
      if (event.key === "Escape") {
        setA(true); // Torna alla Preview e toglie la chat
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
        {/* Scritte in alto */}
        <div className="sezionechat">
          <h4>Chat</h4>
          <ul>
            <li>
              <a href="#" onClick={() => alert("Hai cliccato su Nuova Chat!")}>
                <Image
                  className="img-fluid inverso"
                  src="/images/nuovachat.png"
                  alt="Nuova chat"
                  title="Nuova chat"
                  width={30}
                  height={30}
                />
              </a>
            </li>
            <li>
              <a href="#" onClick={() => alert("Hai cliccato sui Tre Puntini")}>
                <Image
                  className="img-fluid inverso"
                  src="/images/trepunti.png"
                  alt="Trepunti"
                  title="Tre puntini"
                  width={30}
                  height={30}
                />
              </a>
            </li>
          </ul>
        </div>

        {/* La ricerca coi suoi filtri */}
        <div className="ricerca">
          <Image
            className="img-fluid lente"
            src="/images/lente.png"
            alt="lente"
            width={20}
            height={20}
          />
          <input type="text" placeholder="Cerca" />
        </div>

        <div>
          <ul id="filtri">
            <li>
              <a href="#">Tutte</a>
            </li>
            <li>
              <a href="#">Da leggere</a>
            </li>
            <li>
              <a href="#">Preferiti</a>
            </li>
            <li>
              <a href="#">Gruppi</a>
            </li>
          </ul>
        </div>

        {/* Inserisco tutte le chat dal file json */}
        <div className="lechat">
          {chats.map((chat) => (
            <div
              className="chat"
              key={chat.name} // Assicurati di avere una chiave unica per ogni chat
              onClick={() => handleChatClick(chat)} // Passa la chat selezionata alla funzione
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
                  {/* Mostra l'ultimo messaggio con un limite di caratteri */}
                  {chat.messages[chat.messages.length - 1].type === "mio"
                    ? "Io: "
                    : ""}
                  {chat.messages[chat.messages.length - 1].content.slice(0, 60)}
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
      {a ? (
        <div className="contenuto">
          <Preview />
        </div>
      ) : (
        <div className="messaggi">
          {selectedChat && <ChatSingola chat={selectedChat} />}
        </div>
      )}
    </>
  );
};

export default Laterale;
