import React, { useEffect, useRef, useState } from "react";
import Image from "next/image";
import { MdOutlineEmojiEmotions } from "react-icons/md";
import { GoChevronDown } from "react-icons/go";
import { RiCheckDoubleFill } from "react-icons/ri";
import { MessageChoices } from "./MessageChoices";

interface Message {
  id: string;
  username: string;
  content: string;
  sent_at: string;
  seen: "yes" | "no";
  chat_type: "single" | "group";
  message_type: string;
  media_content: string;
}

interface ChatSingolaProps {
  username: string;
  icon: string;
  last_access: string;
  name: string;
  type: "single" | "group";
}

interface Settings {
  user_id: string;
  username: string;
  setting_name: string;
  setting_value: string;
}

interface ChatSingolaID {
  selectedChat: string | null;
  selectedChatType: string | null;
}

interface ID {
  id: string;
  username: string;
}

const ChatSingola: React.FC<ChatSingolaID & ID> = ({
  selectedChat,
  selectedChatType,
  id,
  username,
}) => {
  const idUserAttuale = id;
  const nomeUserAttuale = username;

  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const [isAdmin, setIsAdmin] = useState<string>("false");
  useEffect(() => {
    if (selectedChat) {
      fetch(
        `http://localhost:8000/isChatAdmin?Achat_id=${selectedChat}&Auser_id=${idUserAttuale}`
      )
        .then((response) => response.json())
        .then((data) => {
          console.log("E' Admin?: ", data.isAdmin);
          setIsAdmin(data.isAdmin);
        })
        .catch((error) => {
          console.error("Errore:", error);
        });
    }
  }, [idUserAttuale, selectedChat]);

  const [messages, setMessages] = useState<Message[]>([]);
  useEffect(() => {
    if (selectedChat && selectedChatType == "single") {
      fetch(
        `http://localhost:3000/selectAllSingleMessages.php?chat_id=${selectedChat}&user_id=${idUserAttuale}`
      )
        .then((response) => response.json())
        .then((data) => {
          console.log("Messaggi ricevuti:", data);
          setMessages(data);
        })
        .catch((error) => {
          console.error("Errore:", error);
        });
    } else if (selectedChat && selectedChatType == "group") {
      fetch(
        `http://localhost:3000/selectAllGroupMessages.php?chat_id=${selectedChat}&user_id=${idUserAttuale}`
      )
        .then((response) => response.json())
        .then((data) => {
          console.log("Messaggi ricevuti:", data);
          setMessages(data);
        })
        .catch((error) => {
          console.error("Errore:", error);
        });
    }
  }, [selectedChat]);

  // Per fetchare ogni secondo
  // const [messages, setMessages] = useState<Message[]>([]);
  // useEffect(() => {
  //   if (!selectedChat) return;

  //   const fetchMessages = () => {
  //     if (selectedChatType === "single") {
  //       fetch(
  //         `http://localhost:3000/selectAllSingleMessages.php?chat_id=${selectedChat}&user_id=${idUserAttuale}`
  //       )
  //         .then((response) => response.json())
  //         .then((data) => {
  //           console.log("Messaggi ricevuti (singola chat):", data);
  //           setMessages(data);
  //         })
  //         .catch((error) => {
  //           console.error(
  //             "Errore nel caricamento dei messaggi singola chat:",
  //             error
  //           );
  //         });
  //     } else if (selectedChatType === "group") {
  //       fetch(
  //         `http://localhost:3000/selectAllGroupMessages.php?chat_id=${selectedChat}&user_id=${idUserAttuale}`
  //       )
  //         .then((response) => response.json())
  //         .then((data) => {
  //           console.log("Messaggi ricevuti (chat di gruppo):", data);
  //           setMessages(data);
  //         })
  //         .catch((error) => {
  //           console.error(
  //             "Errore nel caricamento dei messaggi chat di gruppo:",
  //             error
  //           );
  //         });
  //     }
  //   };
  //   fetchMessages();
  //   const intervalId = setInterval(fetchMessages, 1000);
  //   return () => clearInterval(intervalId);
  // }, [selectedChat, selectedChatType, idUserAttuale]);

  const [user, setUser] = useState<ChatSingolaProps>();
  useEffect(() => {
    if (selectedChat) {
      fetch(
        `http://localhost:8000/selectUserDetails?chat_id=${selectedChat}&user_id=${idUserAttuale}`
      )
        .then((response) => response.json())
        .then((data) => {
          console.log("User ricevuti:", data);
          setUser(data[0]);
        })
        .catch((error) => {
          console.error("Errore:", error);
        });
    }
  }, [selectedChat]);

  const [settings, setSettings] = useState<Settings[] | 0>(0);
  useEffect(() => {
    if (selectedChat) {
      fetch(`http://localhost:3000/getChatSettings.php?chat_id=${selectedChat}`)
        .then((response) => response.json())
        .then((data) => {
          console.log("Settings della chat selezionate:", data);
          setSettings(data.length > 0 ? data : 0);
        })
        .catch((error) => {
          console.error("Errore:", error);
        });
    }
  }, [selectedChat]);

  const conferma_lettura = (): string => {
    if (settings === 0) {
      return "yes";
    }

    for (const setting of settings) {
      if (
        setting.setting_name === "conferme_lettura" &&
        setting.setting_value === "no"
      ) {
        return "no";
      }
    }

    return "yes";
  };

  const ultimo_accesso = (): string => {
    if (settings == 0) {
      return "no";
    }

    for (const setting of settings) {
      if (
        setting.setting_name === "ultimo_accesso" &&
        setting.setting_value === "no"
      ) {
        return "no";
      }
    }
    return "yes";
  };

  // Gestione della ScrollBar
  const messagesRef = useRef<HTMLDivElement | null>(null);
  useEffect(() => {
    if (messagesRef.current) {
      messagesRef.current!.scrollTop = messagesRef.current!.scrollHeight;
    }
  }, [messages]);

  // Gestione del Microfono o Freccia
  const [inputValue, setInputValue] = useState<string>("");
  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setInputValue(e.target.value);
  };

  const handleMessageSent = (inputValue: string) => {
    const chatId = selectedChat ?? "";

    fetch("http://localhost:3000/insertMessage.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        chat_id: chatId,
        user_id: idUserAttuale,
        content: inputValue,
      }),
    })
      .then((response) => response.text())
      .then((data) => {
        console.log("Risposta del server:", data);
      })
      .then(() => setInputValue(""))
      .catch((error) => {
        console.error("Errore durante l'invio del messaggio:", error);
      });
  };

  // Gestione della lista "rispondi" ecc.
  const [activeIndex, setActiveIndex] = useState<number | null>(null);
  const handleChevronClick = (index: number) => {
    setActiveIndex((prevIndex) => (prevIndex === index ? null : index));
  };

  // Chiudi il Chevron cliccando 1 sulla tastiera
  useEffect(() => {
    const handleKeyDown = (event: KeyboardEvent) => {
      if (event.key === "1") {
        setActiveIndex(null);
      }
      event.stopPropagation();
    };
    document.addEventListener("keydown", handleKeyDown);
    return () => {
      document.removeEventListener("keydown", handleKeyDown);
    };
  }, []);

  // Manda il messaggio premento INVIO
  useEffect(() => {
    const handleKeyDown = (event: KeyboardEvent) => {
      if (event.key === "Enter") {
        handleMessageSent(inputValue);
      }
      event.stopPropagation();
    };
    document.addEventListener("keydown", handleKeyDown);
    return () => {
      document.removeEventListener("keydown", handleKeyDown);
    };
  }, [inputValue]);

  const getInitials = (name: string): string => {
    const words = name.split(" ");

    return words.map((word) => word[0].toUpperCase()).join("");
  };

  // Funzione per generare un colore unico passando il nome dell'utente
  const generateColor = (name: string) => {
    let hash = 0;
    for (let i = 0; i < name.length; i++) {
      hash = name.charCodeAt(i) + ((hash << 5) - hash);
    }
    const color = (hash & 0x00ffffff).toString(16).toUpperCase(); // Prendi solo l'RGB
    return `#${"00000".substring(0, 6 - color.length) + color}`; // Completa con 0 per evitare colori troppo chiari
  };

  const isSameDay = (date1: string, date2: string): boolean => {
    const d1 = new Date(date1);
    const d2 = new Date(date2);
    return d1.toDateString() === d2.toDateString();
  };

  const isNotToday = (sent_at: string, previousDate: string): string => {
    const messageDate = new Date(sent_at);
    const todayMidnight = new Date(today);
    const yesterdayMidnight = new Date(todayMidnight);
    yesterdayMidnight.setDate(todayMidnight.getDate() - 1);

    if (previousDate && isSameDay(sent_at, previousDate)) {
      return ""; // Non scrivere la data se è lo stesso giorno del messaggio precedente
    } else if (
      messageDate >= yesterdayMidnight &&
      messageDate < todayMidnight
    ) {
      return "IERI";
    } else if (messageDate < yesterdayMidnight) {
      return messageDate.toLocaleDateString();
    }
    return "OGGI";
  };

  const Choices = [
    { choiceName: "Rispondi" },
    { choiceName: "Reagisci" },
    { choiceName: "Inoltra" },
    { choiceName: "Fissa" },
    { choiceName: "Importante" },
    { choiceName: "Segnala" },
    { choiceName: "Elimina" },
  ];
  return (
    <>
      <div
        className="sezione-utente"
        onClick={() => alert("Sei andato nelle informazioni dell'utente")}
      >
        {user && user.name == "" ? (
          <Image
            className="img-fluid profilo"
            src={user.icon}
            alt={getInitials(user.username)}
            width={70}
            height={70}
          />
        ) : user && user.name != "" ? (
          <Image
            className="img-fluid profilo"
            width={70}
            height={70}
            src={"/images/default_icon.jpg"}
            alt={getInitials(user.name)}
          />
        ) : (
          []
        )}
        <div>
          {user?.name == "" ? (
            <h4>
              {user?.username} <br />
            </h4>
          ) : (
            <h4>
              {user?.name}
              <br />
            </h4>
          )}

          <p className="accesso">
            {ultimo_accesso() === "yes" && user?.type == "single"
              ? user?.last_access.slice(11, 16)
              : []}
          </p>
        </div>
        <span className="icone-utente">
          <Image
            className="img-fluid lente-trepunti"
            src="/images/lente.png"
            alt="Lente"
            width={20}
            height={20}
          />
          <Image
            className="img-fluid lente-trepunti"
            src="/images/trepunti.png"
            alt="Tre punti"
            width={20}
            height={20}
          />
        </span>
      </div>

      {/* I messaggi */}
      <div className="sezione-messaggi" ref={messagesRef}>
        {messages.map((message, index) => {
          // Prendo il messaggio precedente che mi serve per gestire le scritte "OGGI", "IERI" o "XX-XX-XX XX:XX:XX"
          const previousMessageSentAt =
            index > 0 ? messages[index - 1].sent_at : "";

          const displayDate = isNotToday(
            message.sent_at,
            previousMessageSentAt
          );
          // Verifica se è il primo messaggio di una sequenza
          const MettoPisellino =
            index === 0 || messages[index - 1].id !== message.id;
          return (
            <>
              {displayDate && (
                <div className="data">
                  <div className="datedivider">{displayDate}</div>
                </div>
              )}
              <div
                key={index}
                className={
                  message.content == ""
                    ? "nessuno"
                    : message.username == nomeUserAttuale
                    ? "messaggio-mio"
                    : "messaggio-altro"
                }
              >
                <p>
                  {MettoPisellino && <span className="pisellino"></span>}
                  {message.username != nomeUserAttuale &&
                  message.chat_type == "group" ? (
                    <small>
                      <b style={{ color: generateColor(message.username) }}>
                        {message.username} <br />
                      </b>
                    </small>
                  ) : (
                    []
                  )}
                  {message.message_type == "message" ? (
                    message.content
                  ) : (
                    <>
                      <img src={message.content} alt="Immagine" /> <br />
                      <span>{message.media_content}</span>
                    </>
                  )}
                  <span className="orario">
                    {message.sent_at.slice(11, 16)}

                    {/* Gestione conferma di lettura */}
                    {conferma_lettura() === "yes" ? (
                      message.username === nomeUserAttuale &&
                      message.seen === "yes" ? (
                        <RiCheckDoubleFill size={18} color="#007FFF" />
                      ) : message.username === nomeUserAttuale &&
                        message.seen === "no" ? (
                        <RiCheckDoubleFill size={18} color="grey" />
                      ) : null
                    ) : message.username === nomeUserAttuale ? (
                      <RiCheckDoubleFill size={18} color="grey" />
                    ) : null}
                  </span>
                  <span className="chevron rounded-5 rounded-top-0">
                    <GoChevronDown
                      size={24}
                      onClick={() => handleChevronClick(index)}
                    />
                  </span>
                  {activeIndex === index && (
                    <ul className="list-group">
                      {Choices.map((choice) => {
                        return (
                          <MessageChoices
                            isAdmin={isAdmin}
                            choiceName={choice.choiceName}
                            chatType={message.chat_type}
                          />
                        ); //è la tendina che sbuca quando schiacci sul chevron
                      })}
                    </ul>
                  )}
                </p>
                <span
                  className="emoji"
                  onClick={() => alert("Hai cliccato l'Emoji")}
                >
                  <MdOutlineEmojiEmotions size={24} />
                </span>
              </div>
            </>
          );
        })}
      </div>

      <div className="sezione-manda-messaggi">
        <Image
          className="img-fluid invertito"
          src="/images/smile.png"
          alt="Smile"
          onClick={() => alert("Hai cliccato l'Emoji")}
          width={40}
          height={40}
        />
        <Image
          className="img-fluid invertito"
          src="/images/plus.png"
          alt="Plus"
          onClick={() => alert("Hai cliccato per aggiungere un file")}
          width={40}
          height={40}
        />

        <input
          type="text"
          placeholder="Scrivi un messaggio"
          value={inputValue}
          onChange={handleInputChange}
        />

        {inputValue ? (
          <Image
            className="img-fluid invertito"
            src="/images/send.png"
            alt="Manda messaggio"
            onClick={() => handleMessageSent(inputValue)}
            width={40}
            height={40}
          />
        ) : (
          <Image
            className="img-fluid invertito"
            src="/images/microfono.png"
            alt="Microfono"
            onClick={() => alert("Hai cliccato il microfono")}
            width={40}
            height={40}
          />
        )}
      </div>
    </>
  );
};

export default ChatSingola;
