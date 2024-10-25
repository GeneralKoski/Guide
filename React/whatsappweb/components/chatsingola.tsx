import React, { useEffect, useRef, useState } from "react";
import Image from "next/image";
import { MdOutlineEmojiEmotions } from "react-icons/md";
import { GoChevronDown } from "react-icons/go";
import { RiCheckDoubleFill } from "react-icons/ri";
import { MessageChoices } from "./MessageChoices";

interface Message {
  type: "mio" | "altri" | "nessuno";
  content: string;
  time: string;
}

interface ChatSingolaProps {
  chat: {
    icon: string;
    name: string;
    access: string;
    messages: Message[];
  };
}

const ChatSingola: React.FC<ChatSingolaProps> = ({ chat }) => {
  // Gestione della ScrollBar
  const messagesRef = useRef<HTMLDivElement | null>(null);
  useEffect(() => {
    if (messagesRef.current) {
      messagesRef.current.scrollTop = messagesRef.current.scrollHeight;
    }
  }, [chat.messages]);

  // Gestione del Microfono o Freccia
  const [inputValue, setInputValue] = useState<string>("");
  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setInputValue(e.target.value);
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
        <Image
          className="img-fluid profilo"
          src={chat.icon}
          alt={chat.name}
          width={70}
          height={70}
        />
        <div>
          <h4>{chat.name}</h4> <br />
          <p className="accesso">{chat.access}</p>
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
        {chat.messages.map((message, index) => {
          // Verifica se è il primo messaggio di una sequenza
          const MettoPisellino =
            index === 0 || chat.messages[index - 1].type !== message.type;

          return (
            <div
              key={index}
              className={
                message.type === "mio"
                  ? "messaggio-mio"
                  : message.type === "altri"
                  ? "messaggio-altro"
                  : "nessuno"
              }
            >
              <p>
                {MettoPisellino && <p className="pisellino"></p>}
                {message.content}
                <span className="orario">
                  {message.time}
                  {message.type === "mio" ? (
                    <RiCheckDoubleFill size={18} color="#007FFF" />
                  ) : (
                    []
                  )}
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
                      return <MessageChoices choiceName={choice.choiceName} />;
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
            onClick={() => alert("Hai cliccato per mandare un messaggio")}
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
