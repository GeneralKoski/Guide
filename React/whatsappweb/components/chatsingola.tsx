import React, { useEffect, useRef, useState } from "react";
import Image from "next/image";

// Definizione dei tipi per i messaggi e la chat
interface Message {
  type: "mio" | "altri";
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
  const messagesRef = useRef<HTMLDivElement | null>(null);
  const [inputValue, setInputValue] = useState<string>("");

  // Funzione per scrollare automaticamente in fondo
  const scrollToBottom = () => {
    if (messagesRef.current) {
      messagesRef.current.scrollTop = messagesRef.current.scrollHeight;
    }
  };

  // Effetto che scrolla in fondo quando i messaggi cambiano
  useEffect(() => {
    scrollToBottom();
  }, [chat.messages]);

  // Funzione per gestire il cambio di input
  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setInputValue(e.target.value); // Aggiorna lo stato dell'input
  };

  return (
    <>
      {/* SEZIONE IN ALTO DOVE STANNO LE INFORMAZIONI DELL'UTENTE */}
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

      {/* SEZIONE AL CENTRO DOVE STA L'ELENCO DEI VARI MESSAGGI */}
      <div className="sezione-messaggi" ref={messagesRef}>
        {chat.messages.map((message, index) => (
          <div
            key={index}
            className={
              message.type === "mio" ? "messaggio-mio" : "messaggio-altro"
            }
          >
            <p>
              {message.content}
              <span className="orario">{message.time}</span>
            </p>
          </div>
        ))}
      </div>

      {/* SEZIONE IN BASSO DOVE SI SCRIVE IL MESSAGGIO */}
      <div className="sezione-manda-messaggi">
        <Image
          className="img-fluid invertito"
          src="/images/smile.png"
          alt="Smile"
          onClick={() => alert("Hai cliccato per vedere le Emoji")}
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

        {/* Input per il messaggio */}
        <input
          type="text"
          placeholder="Scrivi un messaggio"
          value={inputValue}
          onChange={handleInputChange}
        />

        {/* Icona microfono o invio, a seconda dello stato dell'input */}
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
